<?php

use App\Controllers\Auction as auction;

$app->get('/', function ($request, $response) {
    $this->logger->addInfo('Home page, /, route called');
    $template = $this->twig->load('home.twig');
    return $template->render(array(
                            'name' => 'Auction'
                        ));
})->setName('index');
