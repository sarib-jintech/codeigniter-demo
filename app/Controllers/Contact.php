<?php
namespace App\Controllers;

use App\Models\ContactUsModel;

class Contact extends BaseController
{
    public function getCompanyInfo()
    {

        return $this->response->setJSON([
            'result' => 'success',
            'message' => 'Company info fetched successfully',
            "data" => [
                "company_address" => "PO Box 426",
                "company_city" => "Shelburne Falls",
                "company_state" => "MA",
                "company_zip" => "01370",
                "main_phone" => "+1-888-561-6859",
                "fax" => "",
                "main_email" => "info@auctionmethod.com"
            ]
        ]);
    }
    public function submitContactForm()
    {
        $data = $this->request->getJSON(true);

        $contactUs = model(ContactUsModel::class);

        $contactUs->insert([
            'name' => $data['from'],
            'email' => $data['from_email'],
            'company' => $data['company'] ?? '',
            'subject' => $data['subject'] ?? '',
            'phone' => $data['phone'] ?? '',
            'body' => $data['body'],
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Contact form submitted successfully'
        ]);
    }

}