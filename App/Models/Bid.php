<?php

namespace App\Models;

class Bid {

    public function __construct($app)
	{
        $this->app = $app;
        $this->db = $app['db'];
        $this->logger = $app->logger;
    }  

    /**
     * Add a bid.
     *
     * @param  $itemId
     * @param  $bidPrice
     * @param  $userId
     *
     * @return array
     */
    public function bidAdd($itemId, $bidPrice, $userId)
    {
        $this->logger->addInfo('Add Bid for item Id ' . $itemId . 'with a bid price of ' . $bidPrice . ' for user Id ' . $userId);

        $bidAddSQL = $this->db->table('bid')->insertGetId(
            [
                'item_id' => $itemId,
                'bid_price' => $bidPrice,
                'user_id' => $userId
            ]
        );

		if(!$bidAddSQL) {
			return false;
        }
        
        return true;
    }
}