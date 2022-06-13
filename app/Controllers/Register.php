<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Register extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]'
            ],
            'password' => [
                'rules' => 'required|min_length[6]'
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]'
            ]
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel;

            $userData = [
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
            ];

            $userModel->save($userData);

            return $this->respond(['status' => true, 'message' => 'Register berhasil'], 200);
        } else {
            $response = [
                'status' => false,
                'errors' => $this->validator->getErrors(),
            ];

            return $this->respond($response, 422);
        }
    }
}
