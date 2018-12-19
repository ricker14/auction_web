<?php

use App\Controllers\Auction as auction;

$app->get('/', function ($request, $response) {
    $this->logger->addInfo('Home page, /, route called');
    $item = new auction( $this );
    $itemList = $item->itemList();
    $template = $this->twig->load('home.twig');
    return $template->render(array(
                            'name' => 'Auction',
                            'itemList' => $itemList
                        ));
})->setName('home');

// Bid on an Item
$app->post( '/bid/item', function ($request, $response) {
    $this->logger->addInfo('Bid on an Item post page, /bid/item, route called');

    $bid = new auction( $this );
    $bidItem = $bid->bidAdd($request);
    $url = $this->router->pathFor('home');
    return $response->withHeader('Location', $url);
})->setName('bidItem');