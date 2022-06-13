<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $userModel = new UserModel;

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return $this->respond(['status' => false, 'message' => 'Username atau Password salah'], 401);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->respond(['status' => false, 'message' => 'Username atau Password salah'], 401);
        }

        $key = getenv("JWT_SECRET");

        $iat = time();
        $exp = $iat + (60*60);

        $payload = [
            'iss' => 'ci4-jwt',
            'sub' => 'logintoken',
            'iat' => $iat,
            'exp' => $exp,
            'email' => $email
        ];

        $token = JWT::encode($payload, $key, "HS256");

        return $this->respond(['status' => true, 'token' => $token], 200);
    }
}
