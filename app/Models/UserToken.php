<?php
namespace App\Models;

use CodeIgniter\Model;

class UserToken extends Model
{
    protected $table = 'usertokens';
    protected $primaryKey = 'usertoken';
    protected $allowedFields = ['usertoken', 'email', 'isactive'];

    public function addUserToken($email, $token)
    {
        $this->db->table($this->table)->insert([
            'email' => $email,
            'isactive' => true,
            'usertoken' => $token
        ]);
    }
    public function changeActiveToken($token)
    {
        $this->db->table($this->table)->update([
            'isactive' => false
        ], ['usertoken' => $token]);
    }

    public function checkToken($token)
    {
        return $this->db->table($this->table)->where(['usertoken' => $token, 'isactive' => true])->get()->getRow();
    }
    public function getEmail($token)
    {
        return $this->db->table($this->table)->where(['usertoken' => $token, 'isactive' => true])->get()->getRow()->email;
    }
}