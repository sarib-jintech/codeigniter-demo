<?php

namespace App\Controllers;

use App\Models\AuctionItemBidModel;
use App\Models\AuctionsModel;
use App\Models\AuctionItemModel;
use App\Models\FavoriteItemModel;
use App\Models\InvoiceModel;
use App\Models\UserToken;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auctions extends BaseController
{
    public function getAuctions()
    {
        $model = model(AuctionsModel::class);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Auctions retrieved successfully',
            'auctions' => $model->getAuctions()
        ]);
    }
    public function getAuctionsItems($id)
    {
        $model = model(AuctionItemModel::class);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Auctions items retrieved successfully',
            'auction' => $model->getAuctionItems($id)
        ]);
    }
    public function getWatchlist()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        try {
            $decoded = JWT::decode($token, new Key("muhammadsarib_super_secret_key_1234567890", 'HS256'));
            $tokenModel = model(UserToken::class);
            $token = $tokenModel->checkToken($token);
            if ($token) {
                $email = $decoded->data->email;
                $model = model(FavoriteItemModel::class);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Watchlist retrieved successfully',
                    'data' => [
                        'items' => $model->getAllFavorites($email)
                    ]
                ]);
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
                'token' => $e->getMessage()
            ]);
        }
    }
    public function addWatchlist()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        $data = $this->request->getJSON(true);
        $itemid = $data['itemid'] ?? null;
        try {
            $decoded = JWT::decode($token, new Key("muhammadsarib_super_secret_key_1234567890", 'HS256'));
            $tokenModel = model(UserToken::class);
            $token = $tokenModel->checkToken($token);
            if ($token) {
                $email = $decoded->data->email;
                $model = model(FavoriteItemModel::class);
                $model->setFavorite($email, $itemid);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Item added to watchlist successfully'
                ]);
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
                'token' => $e->getMessage()
            ]);
        }
    }
    public function removeWatchlist(int $id)
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        try {
            $decoded = JWT::decode($token, new Key("muhammadsarib_super_secret_key_1234567890", 'HS256'));
            $tokenModel = model(UserToken::class);
            $token = $tokenModel->checkToken($token);
            if ($token) {
                $email = $decoded->data->email;
                $model = model(FavoriteItemModel::class);
                $model->removeFavorite($email, $id);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Item removed from watchlist successfully'
                ]);
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
                'token' => $e->getMessage()
            ]);
        }
    }
    public function auctionBids()
    {
        $auctionId = $this->request->getGet('auctionid');
        $itemId = $this->request->getGet('itemid');
        $model = model(AuctionItemBidModel::class);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Auction bids retrieved successfully',
            'data' => $model->getAuctionItemBids($auctionId, $itemId)
        ]);
    }
    public function addBid()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        try {
            $decoded = JWT::decode($token, new Key("muhammadsarib_super_secret_key_1234567890", 'HS256'));
            $tokenModel = model(UserToken::class);
            $token = $tokenModel->checkToken($token);
            if ($token) {
                $userEmail = $decoded->data->email;
                $data = $this->request->getJSON(true);
                $auctionId = $data['auctionid'] ?? null;
                $itemId = $data['itemid'] ?? null;
                $bidAmount = $data['amount'] ?? null;
                $model = model(AuctionItemBidModel::class);
                $model->addBid($auctionId, $itemId, $bidAmount, $userEmail);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Bid added successfully'
                ]);
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
                'token' => $e->getMessage()
            ]);
        }
    }
    public function getUserBids()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        try {
            $decoded = JWT::decode($token, new Key("muhammadsarib_super_secret_key_1234567890", 'HS256'));
            $tokenModel = model(UserToken::class);
            $token = $tokenModel->checkToken($token);
            if ($token) {
                $userEmail = $decoded->data->email;
                $model = model(AuctionItemBidModel::class);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'User bids retrieved successfully',
                    'items' => $model->getUserBids($userEmail)
                ]);
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
                'token' => $e->getMessage()
            ]);
        }
    }
    public function getUserInvoices()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        try {
            $decoded = JWT::decode($token, new Key("muhammadsarib_super_secret_key_1234567890", 'HS256'));
            $tokenModel = model(UserToken::class);
            $token = $tokenModel->checkToken($token);
            if ($token) {
                $userEmail = $decoded->data->email;
                $model = model(InvoiceModel::class);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'User invoices retrieved successfully',
                    'data' => $model->getInvoices($userEmail)
                ]);
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid token',
                'token' => $e->getMessage()
            ]);
        }
    }
}