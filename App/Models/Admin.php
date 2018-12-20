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
                'linkName',
                'linkURL',
                'linkIcon')
                ->where('is_admin', 1)
            ->get();

		if(!$linkList) {
			return false;
        }
                
        return $linkList;
    }
}