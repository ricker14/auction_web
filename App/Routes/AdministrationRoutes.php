<?php

use App\Controllers\Administration as admin;

// Administration
$app->group('/admin', function () use ($app) {

    // Administration home
    $app->get('', function ($request, $response) {
        $this->logger->addInfo('Admin home page, /admin, route called');
        $admin = new admin( $this );
        $linkList = $admin->linkList();
        $template = $this->twig->load('adminHome.twig');
        return $template->render(array(
                                'name' => 'Administration',
                                'links' => $linkList
                            ));
    })->setName('adminHome');

    // Add a User
    $app->get('/add/user', function ($request, $response) {
        $this->logger->addInfo('Add User, /add/user, route called');
        $template = $this->twig->load('addUser.twig');
        return $template->render(array(
                                'name' => 'Add User'
                            ));
    })->setName('addUserForm');


    // Add an Item
    $app->get('/add/item', function ($request, $response) {
        $this->logger->addInfo('Add Item page, /add/item, route called');
        $template = $this->twig->load('addItem.twig');

        return $template->render(array(
                                'name' => 'Add Item'
                            ));
    })->setName('addItemForm');

    // Add an Item - POST
    $app->post( '/add/item/post', function ($request, $response) {
        $this->logger->addInfo('Add Item post page, /add/item, route called');

        $files = $request->getUploadedFiles();
        if (empty($files['itemImage'])) {
            throw new Exception('Expected an image.');
        }
    
        $itemImage = $files['itemImage'];
        if ($itemImage->getError() === UPLOAD_ERR_OK) {
            $uploadFileName = $itemImage->getClientFilename();
            $uploadedItemImage = $this->settings['storagePath'] . '' . $uploadFileName;
            $itemImage->moveTo($uploadedItemImage);
        }

        $item = new auction( $this );
        $newItem = $item->itemAdd($request, $uploadedItemImage);
        $url = $this->router->pathFor('addItemForm');
        return $response->withHeader('Location', $url);
    })->setName('addItemPost');

});
