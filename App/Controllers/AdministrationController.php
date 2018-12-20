<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\User as user;
use App\Models\Item as item;
use App\Models\Admin as admin;

class Administration
{
    private $app;
    
    public function __construct($app)
    {
        $this->app = $app;
        $this->app->db->connection();
        $this->logger = $app->logger;
    }

    /**
	 * List Links.
	 *
	 * @return array
	 */
	public function linkList()
	{        
        
        $adminModel = new admin( $this->app );
        $linkList = $adminModel->linkList();
        
        if($itemList === false) {
            $this->logger->info('There was an error adding the item.');
        }

        $this->logger->info('Add an item.');
        return $itemList;
    }

    /**
	 * Add an item.
	 *
	 * @param  $request
	 *
	 * @return object
	 */
	public function itemAdd($request, $itemImage)
	{        
        $itemName = $request->getParsedBody()['itemName'];
        $itemDescription = isset($request->getParsedBody()['itemDesc']) ? $request->getParsedBody()['itemDesc'] : '';
        $itemBasePrice = $request->getParsedBody()['itemBasePrice'];

        $itemModel = new item( $this->app );
        $itemAdd = $itemModel->itemAdd($itemName, $itemDescription, $itemBasePrice, $itemImage, $request);
        
        if($itemAdd === false) {
            $this->logger->info('There was an error adding the item.');
            return([
				'addItemColor' => 'red',
                'addItemMessage' => 'There was an error adding the item.',
            ]);
        }

        $this->logger->info('Add an item.');
        return([
            'addItemColor' => 'green', 
            'addItemMessage' => 'Item added'
        ]);
    }

    /**
	 * Add a user.
	 *
	 * @param  $request
	 *
	 * @return object
	 */
	public function userAdd($request, $itemImage)
	{        
        $userFirstName = $request->getParsedBody()['userFirstName'];
        $userLastName = $request->getParsedBody()['userLastName'];
        $userEmail = $request->getParsedBody()['userEmail'];

        $userModel = new item( $this->app );
        $userAdd = $userModel->userAdd($itemName, $itemDescription, $itemBasePrice, $itemImage, $request);
        
        if($userAdd === false) {
            $this->logger->info('There was an error adding the user.');
            return([
				'addItemColor' => 'red',
                'addItemMessage' => 'There was an error adding the user.',
            ]);
        }

        $this->logger->info('Add a user.');
        return([
            'addItemColor' => 'green', 
            'addItemMessage' => 'User added'
        ]);
    }

}
