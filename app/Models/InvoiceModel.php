<?php
namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $allowedFields = ['auction_id', 'user_email', 'title', 'item_count', 'sub_total', 'paid', 'created'];
    protected $useTimestamps = true;
    public function createInvoice($auctionId, $userEmail, $title, $itemCount, $subTotal, $paid)
    {
        $this->insert([
            'auction_id' => $auctionId,
            'user_email' => $userEmail,
            'title' => $title,
            'item_count' => $itemCount,
            'sub_total' => $subTotal,
            'paid' => $paid
        ]);
    }
    public function getInvoices($userEmail)
    {
        return $this->where('user_email', $userEmail)->findAll();
    }
}