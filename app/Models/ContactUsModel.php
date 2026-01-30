<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactUsModel extends Model
{
    protected $table = 'contact_us';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'company', 'subject', 'phone', 'body'];

    public function addContactUs($name, $email, $company, $subject, $phone, $body)
    {
        $this->insert([
            'name' => $name,
            'email' => $email,
            'company' => $company,
            'subject' => $subject,
            'phone' => $phone,
            'body' => $body
        ]);
    }
}