<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login_view');
    }

    public function authenticate()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Store user session data
            session()->set('isLoggedIn', true);
            session()->set('user', $user);

            // Set flash message
            session()->setFlashdata('success', 'You have been successfully logged in.');

            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }
}
