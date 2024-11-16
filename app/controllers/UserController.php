<?php

class UserController extends Controller
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'birth_date' => $_POST['birth_date'],
                'password_hash' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            ];

            if ($userModel->createUser($data)) {
                $this->redirect('/success');
            } else {
                $this->view('register', ['error' => 'Could not register user.']);
            }
        } else {
            $this->view('register');
        }
    }
}
