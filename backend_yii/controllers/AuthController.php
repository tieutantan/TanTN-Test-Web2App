<?php

namespace app\controllers;

use Firebase\JWT\JWT;
use app\models\User;
use Firebase\JWT\Key;
use Yii;
use yii\db\Exception;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends Controller
{
    protected $secretAccessTokenKey = 'Key-pIIuKAX';

    /**
     * @description Validate username with regex pattern matching for alphanumeric string with length 6-20
     * @param $input
     * @return false|int
     */
    private function validUsername($input)
    {   // Check if username is valid alphanumeric string with length 6-20
        return preg_match('/^[a-z0-9]{6,20}$/', $input);
    }

    /**
     * @description Validate password with regex pattern matching for at least one number
     * and one uppercase and lowercase letter, and at least 8 or more characters
     * @param $input
     * @return false|int
     */
    private function validPassword($input)
    {
        return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $input);
    }

    /**
     * @description Validate full name with regex pattern matching for only letters and spaces with length 1-50
     * @param $input
     * @return false|int
     */
    protected function validFullName($input)
    {
        return preg_match('/^[a-zA-Z0-9\s]{1,50}$/', $input);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:8081'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        return $behaviors;
    }

    /**
     * @description Login user
     * @return array
     * @throws UnauthorizedHttpException
     */
    public function actionLogin()
    {
        $postData = \Yii::$app->request->bodyParams;
        $username = $postData['username'];
        $password = $postData['password'];

        if (!$this->validUsername($username)) {
            throw new BadRequestHttpException('Invalid username');
        }

        if (!$this->validPassword($password)) {
            throw new BadRequestHttpException('Invalid password');
        }

        // Authenticate user
        $user = User::findByUsername($username);

        if ($user && $user->validatePassword($password)) {
            $accessToken = $this->createAccessToken($user);
            $user->access_token = $accessToken['accessToken'];
            $user->save();
            return $accessToken;
        } else {
            throw new UnauthorizedHttpException('Invalid username or password');
        }
    }

    public function actionCheck()
    {
        $request = Yii::$app->request;
        $authHeader = $request->getHeaders()->get('Authorization');

        if ($authHeader && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = $matches[1];
            try {
                $decoded = JWT::decode($token, new Key($this->secretAccessTokenKey, 'HS256'));
                return ['data' => $decoded->data];
            } catch (\Exception $e) {
                throw new UnauthorizedHttpException('Invalid token');
            }
        } else {
            throw new UnauthorizedHttpException('No token provided');
        }
    }

    /**
     * @description Register new user
     * @throws Exception
     * @throws \yii\base\Exception
     * @throws BadRequestHttpException
     */
    public function actionRegister()
    {
        $postData = \Yii::$app->request->bodyParams;

        $fullName = $postData['fullName'];
        $username = $postData['username'];
        $password = $postData['password'];

        if (!$this->validFullName($fullName)) {
            throw new BadRequestHttpException('Invalid full name');
        }

        if (!$this->validUsername($username)) {
            throw new BadRequestHttpException('Invalid username');
        }

        if (!$this->validPassword($password)) {
            throw new BadRequestHttpException('Invalid password');
        }

        // create new user
        $user = new User();
        $user->full_name = $fullName;
        $user->username = $username;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);

        if ($user->save()) {
            $accessToken = $this->createAccessToken($user);
            $user->access_token = $accessToken['accessToken'];
            $user->save();
            return $accessToken;
        } else {
            return ['errors' => $user->errors];
        }

    }

    /**
     * @description Create JWT token
     * @param $user
     * @return array
     */
    private function createAccessToken($user)
    {
        $payload = [
            'iat' => time(),
            'exp' => time() + 3600,
            'data' => [
                'userId' => $user->id,
                'username' => $user->username,
                'fullName' => $user->full_name
            ]
        ];

        $jwt = JWT::encode($payload, $this->secretAccessTokenKey, 'HS256');
        return ['accessToken' => $jwt];
    }
}