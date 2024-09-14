<?php

use Firebase\JWT\JWT;
use app\models\User;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        //
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            $key = "your_secret_key";
            $payload = [
                'iss' => "http://example.org",
                'aud' => "http://example.com",
                'iat' => time(),
                'nbf' => time(),
                'exp' => time() + 3600, // Token hết hạn sau 1 giờ
                'data' => [
                    'userId' => $user->id,
                    'username' => $user->username,
                ]
            ];

            $jwt = JWT::encode($payload, $key, 'HS256');
            return ['token' => $jwt];
        } else {
            throw new UnauthorizedHttpException('Invalid username or password');
        }
    }

    /**
     * @throws \yii\db\Exception
     * @throws \yii\base\Exception
     * @throws BadRequestHttpException
     */
    public function actionRegister()
    {
        $request = Yii::$app->request;
        $fullName = $request->post('fullName');
        $username = $request->post('username');
        $password = $request->post('password');

        if (empty($fullName) || empty($username) || empty($password)) {
            throw new BadRequestHttpException('All fields are required');
        }

        $user = new User();
        $user->fullName = $fullName;
        $user->username = $username;
        $user->password = Yii::$app->security->generatePasswordHash($password);

        if ($user->save()) {
            return ['message' => 'User registered successfully'];
        } else {
            return ['errors' => $user->errors];
        }
    }
}