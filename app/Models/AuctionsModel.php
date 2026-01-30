<?php

namespace App\Models;

use CodeIgniter\Model;

class AuctionsModel extends Model
{
    protected $table = 'auctions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'start_date', 'end_date', 'status'];

    public function getAuctions()
    {
        return $this->findAll();
    }
    public function getAuctionById($id)
    {
        return $this->where('id', $id)->first();
    }
}