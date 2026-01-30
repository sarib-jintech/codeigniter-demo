<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AuctionItemModel;

class FavoriteItemModel extends Model
{
    protected $table = 'favorites';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'itemid'];

    public function setFavorite($email, $itemId)
    {
        return $this->insert([
            'email' => $email,
            'itemid' => $itemId
        ]);
    }
    public function getAllFavorites($email)
    {
        $itemids = $this->where('email', $email)->findAll();
        $items = [];
        $auctionItems = model(AuctionItemModel::class);
        foreach ($itemids as $itemid) {
            $items[] = $auctionItems->getAuctionItem($itemid['itemid']);
        }
        return $items;
    }
    public function removeFavorite($email, $itemId)
    {
        return $this->where([
            'email' => $email,
            'itemid' => $itemId
        ])->delete();
    }
}