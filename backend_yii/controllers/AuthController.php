<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends \yii\rest\Controller
{
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        // Xác thực người dùng
        $user = User::findOne(['username' => $username]);
        if ($user && Yii::$app->security->validatePassword($password, $user->password_hash)) {
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
            throw new \yii\web\UnauthorizedHttpException('Invalid username or password');
        }
    }
}
