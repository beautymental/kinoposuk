<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class LoginController extends Controller
{
    public function index(): void
    {
        $this->view(name: 'login', title: 'Вхід');
    }

    public function login()
    {
        $email = $this->request()->input('email');
        $password = $this->request()->input('password');

        if ($this->auth()->attempt($email, $password)) {
            $this->redirect('/');
        }

        $this->session()->set('error', 'Невірний логін або пароль');

        $this->redirect('/login');
    }

    public function logout(): void
    {
        $this->auth()->logout();

        $this->redirect('/');
    }
}
