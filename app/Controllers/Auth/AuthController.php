<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Auth\AuthModel;

class AuthController extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function showRegisterForm() {}

    public function registerUser() {}

    public function showLoginForm() {}

    public function login()
    {
        $json = $this->request->getJSON();
        $email = $json->CORREO;
        $password = $json->CONTRASEÑA;
        $dataUser = $this->authModel->login($email, $password);
        return $this->response->setJSON($dataUser);
    }

    public function logoutUser() {}

    public function showChangePasswordForm() {}

    public function changePassword() {}
}
