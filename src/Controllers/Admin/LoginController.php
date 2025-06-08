<?php

namespace App\Controllers\Admin;

use App\Kernel\Controller\Controller;

class LoginController extends Controller
{
    public function index(): void
    {
        $this->view( 'admin/login', ['title' => 'Вхід']);
    }

    public function login()
    {
        $email = $this->request()->input('email');
        $password = $this->request()->input('password');

        if ($this->auth()->attempt($email, $password)) {
            $this->redirect('/admin');
        }

        $this->session()->set('error', 'Невірний логін або пароль');

        $this->redirect('/admin/login');
    }

    public function logout(): void
    {
        $this->auth()->logout();

        $this->redirect('/admin/login');
    }
}
