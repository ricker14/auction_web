<?php

namespace App\Models;

class Admin {

    public function __construct($app)
	{
        $this->app = $app;
        $this->db = $app['db'];
        $this->logger = $app->logger;
    }  

    /**
     * List Links.
     *
     * @return array
     */
    public function linkList()
    {
        $linkList = $this->db->table('adminLinks')
            ->select(
                'id',
                'linkName',
                'linkURL')
            ->get();

		if(!$linkList) {
			return false;
        }
                
        return $linkList;
    }
}