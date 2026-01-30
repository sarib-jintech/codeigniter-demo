<?php

namespace App\Models;

use CodeIgniter\Model;

class AuctionItemModel extends Model
{
    protected $table = 'auction_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['auction_id', 'item_id', 'current_bid'];

    public function getAuctionItems($id)
    {
        $auctions = model(AuctionsModel::class);

        $auction = $auctions->getAuctionById($id);

        if (!$auction) {
            return null;
        }

        $items = $this->where('auction_id', $id)->findAll();

        $auction['items'] = $items;

        return $auction;
    }
    public function getAuctionItem($id)
    {
        return $this->where('id', $id)->first();
    }
    public function updateBid($auctionId, $itemId, $bidAmount)
    {
        return $this->update([
            'auction_id' => $auctionId,
            'item_id' => $itemId
        ], [
            'current_bid' => $bidAmount
        ]);
    }

}