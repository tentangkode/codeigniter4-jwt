<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use COdeIgniter\API\ResponseTrait;

class User extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userModel = new UserModel;

        return $this->respond(['users' => $userModel->findAll()], 200);
    }
}
