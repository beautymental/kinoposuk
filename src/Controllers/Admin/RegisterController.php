<?php

namespace App\Controllers\Admin;

use App\Kernel\Controller\Controller;

class RegisterController extends Controller
{
    public function index(): void
    {
        $this->view( 'admin/register', ['title' => 'Реєстрація']);
    }

    public function register()
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
        ]);

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/register');
        }

        $email = $this->request()->input('email');
        $password = $this->request()->input('password');

        $this->db()->insert('users', [
            'name' => $this->request()->input('name'),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'is_admin' => 1
        ]);

        if ($this->auth()->attempt($email, $password)) {
            $this->redirect('/admin');
        }

        $this->session()->set('error', 'Невірний логін або пароль');

        $this->redirect('/admin/login');
    }
}
