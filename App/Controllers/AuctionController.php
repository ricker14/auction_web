<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\User as user;
use App\Models\Item as item;

class Auction
{
    private $app;
    
    public function __construct($app)
    {
        $this->app = $app;
        $this->app->db->connection();
        $this->logger = $app->logger;
    }

    /**
	 * List Items.
	 *
	 * @return array
	 */
	public function itemList()
	{        
        
        $itemModel = new Item( $this->app );
        $itemList = $itemModel->itemList();
        
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

        $itemModel = new Item( $this->app );
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
}
