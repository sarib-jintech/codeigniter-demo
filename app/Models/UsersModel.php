<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'email';
    protected $allowedFields = ['email', 'username', 'password', 'phone', 'country_id', 'state_id', 'address', 'city', 'company_name'];
    protected $useAutoIncrement = false;

    public function authenticate($email, $password)
    {
        $user = $this->where([
            'email' => $email,
            'password' => $password
        ])->first();

        return $user;
    }

    public function getToken($email)
    {
        $user = $this->insert([
            'email' => $email,
            'isActive' => 1,
            'token' => bin2hex(random_bytes(32))
        ]);
        return $user;
    }

    public function getUser($email)
    {
        $user = $this->where(['email' => $email])->first();
        $user['user_name'] = $user['username'];
        unset($user['username']);
        return $user;
    }

    public function updateUser(array $data, $userEmail)
    {
        $user = $this->update($userEmail, [
            'phone' => $data['phone'],
            'username' => $data['user_name'],
            'country_id' => $data['country_id'],
            'state_id' => $data['state_id'],
            'address' => $data['address'],
            'city' => $data['city'],
            'company_name' => $data['company_name']
        ]);
        return $user;
    }
    public function checkUser($email)
    {
        $user = $this->where(['email' => $email])->first();
        return $user;
    }
    public function registerUser($data)
    {
        $user = $this->insert([
            'email' => $data['email'],
            'username' => $data['user_name'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'country_id' => $data['country_id'],
            'state_id' => $data['state_id'],
            'address' => $data['address'],
            'city' => $data['city']
            // 'company_name' => $data['company_name']
        ]);
        return $user;
    }
}