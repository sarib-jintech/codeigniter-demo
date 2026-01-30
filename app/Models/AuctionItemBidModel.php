<?php

namespace App\Models;

use CodeIgniter\Model;

class AuctionItemBidModel extends Model
{
    protected $table = 'auction_bids';
    protected $primaryKey = 'id';
    protected $allowedFields = ['auction_id', 'item_id', 'bid_amount', 'user_email', 'time_of_bid'];

    public function getAuctionItemBids($auctionId, $itemId)
    {
        return $this->select('bid_amount AS amount, time_of_bid')
            ->where([
                'auction_id' => $auctionId,
                'item_id' => $itemId
            ])
            ->orderBy('amount', 'DESC')
            ->findAll();
    }

    public function addBid($auctionId, $itemId, $bidAmount, $userEmail)
    {
        $this->insert([
            'auction_id' => $auctionId,
            'item_id' => $itemId,
            'bid_amount' => $bidAmount,
            'user_email' => $userEmail,
            'time_of_bid' => date('Y-m-d H:i:s')
        ]);
        $auctionItem = model(AuctionItemModel::class);
        $auctionItem->updateBid($auctionId, $itemId, $bidAmount);
    }
    public function getUserBids($userEmail)
    {
        $itemIds = $this->select('item_id')
            ->where('user_email', $userEmail)
            ->distinct()
            ->findAll();

        $items = [];
        $key = 0;
        foreach ($itemIds as $row) {
            $item = model(AuctionItemModel::class)->getAuctionItem($row['item_id']);
            $newItem = [];
            if ($item && isset($item['images'])) {
                $item['images'] = json_decode($item['images'], true);
                $newItem['images'] = $item['images'][0];
                $newItem['current_bid'] = $item['current_bid'];
                $newItem['id'] = $item['id'];
                // $newItem['end_time'] = $item['end_time'];
                $newItem['title'] = $item['title'];
                $newItem['key'] = $key;
                $key++;
            }
            $items[] = $newItem;
        }

        return $items;
    }

}