<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use App\Helpers\Mantis as mantis;

class Auction
{
    private $app;
    
    public function __construct($app)
    {
        $this->app = $app;
        $this->app->db->connection('db');
    }
}
