<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\UserToken;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends BaseController
{
    public function index(): string
    {
        return view('auth/index');
    }

    public function tokenValidation(string $token): ?object
    {
        try {
            $decoded = JWT::decode($token, new Key("muhammadsarib_super_secret_key_1234567890", 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function authenticate()
    {
        $data = $this->request->getJSON(true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        $model = model(UsersModel::class);
        $user = $model->authenticate(
            $email,
            $password
        );

        if ($user) {
            $key = "muhammadsarib_super_secret_key_1234567890";

            $payload = [
                'iss' => 'localhost',
                'aud' => 'localhost',
                'iat' => time(),
                'exp' => time() + 3600,
                'data' => [
                    'email' => $user['email'],
                    'username' => $user['username']
                ]
            ];

            $token = JWT::encode($payload, $key, 'HS256');
            $tokenModel = model(UserToken::class);
            $tokenModel->addUserToken($email, $token);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User authenticated successfully',
                'token' => $token
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid email or password',
            'data' => [
                'email' => $email,
                'password' => $password
            ]
        ]);
    }
    public function logout()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        $decoded = $this->tokenValidation($token);
        if ($decoded) {
            $tokenModel = model(UserToken::class);
            $tokenModel->changeActiveToken($token);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Logged out'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token'
            ]);
        }
    }
    public function checkToken()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);

        $decoded = $this->tokenValidation($token);
        if ($decoded) {
            $tokenModel = model(UserToken::class);
            $token = $tokenModel->checkToken($token);
            if ($token) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Token is valid'
                ]);
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token'
            ]);
        }
    }
    public function getEmail()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        $tokenModel = model(UserToken::class);
        $email = $tokenModel->getEmail($token);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Email retrieved successfully',
            'email' => $email
        ]);
    }

    public function dashboard()
    {
        return view('auth/dashboard');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $model = model(UsersModel::class);
        $model->insert([
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
        ]);
        return redirect()->to('/auth');
    }

    public function getUser()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        $decoded = $this->tokenValidation($token);
        if ($decoded) {
            $userEmail = $decoded->data->email;
            $model = model(UsersModel::class);
            $user = $model->getUser($userEmail);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User retrieved successfully',
                'data' => $user
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token'
            ]);
        }
    }
    public function updateUser()
    {
        $data = $this->request->getJSON(true);
        $model = model(UsersModel::class);
        $user = $model->updateUser($data, $data['email']);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }
    public function checkUser()
    {
        $data = $this->request->getJSON(true);
        $model = model(UsersModel::class);
        $user = $model->checkUser($data['email']);
        if ($user) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'A user with this e-mail has already registered.',
            ]);
        }
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'User not found'
        ]);
    }
    public function addUser()
    {
        $data = $this->request->getJSON(true);
        $model = model(UsersModel::class);
        $user = $model->registerUser($data);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => $user
        ]);
    }
}
