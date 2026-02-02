<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/auth', 'Auth::index');
$routes->post('/authenticate', 'Auth::authenticate');
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/store', 'Auth::store');
$routes->get('/user', 'Auth::getUser');
$routes->patch('/user', 'Auth::updateUser');
$routes->post('/register/checkemail', 'Auth::checkUser');
$routes->post('/register', 'Auth::addUser');
$routes->get('/auctions', 'Auctions::getAuctions');
$routes->get('/auctions/items/(:num)', 'Auctions::getAuctionsItems/$1');
$routes->get('/auth/checkToken', 'Auth::checkToken');
$routes->get('/auth/getEmail', 'Auth::getEmail');
$routes->get('/user/watchlist', 'Auctions::getWatchlist');
$routes->post('/user/watchlist', 'Auctions::addWatchlist');
$routes->delete('/user/watchlist/(:num)', 'Auctions::removeWatchlist/$1');
$routes->get('/auctions/bidhistory', 'Auctions::auctionBids');
$routes->post('/auctions/bids', 'Auctions::addBid');
$routes->get('/user/bids', 'Auctions::getUserBids');
$routes->get('/contactus/info', 'Contact::getCompanyInfo');
$routes->post('/contactus', 'Contact::submitContactForm');
$routes->get('/user/invoices', 'Auctions::getUserInvoices');