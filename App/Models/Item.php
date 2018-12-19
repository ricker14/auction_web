<?php

namespace App\Models;

class Item {

    public function __construct($app)
	{
        $this->app = $app;
        $this->db = $app['db'];
        $this->logger = $app->logger;
        $this->storagePath = $app->settings['storagePath'];
    }  

    /**
     * List items.
     *
     * @return array
     */
    public function itemList()
    {
        $itemList = $this->db->table('item')
            ->select(
                'id',
                'name',
                'description',
                'image',
                'base_price',
                'latest_bid_price')
            ->where('status_id', 2)
            ->get();

		if(!$itemList) {
			return false;
        }
                
        return $itemList;
    }

    /**
     * Add an item.
     *
     * @param  $itemName
     * @param  $itemDescription
     * @param  $itemBasePrice
     *
     * @return array
     */
    public function itemAdd($itemName, $itemDescription, $itemBasePrice, $itemImage, $request)
    {
        $this->logger->addInfo('Add Item Name: ' . $itemName);
        $this->logger->addInfo('Add Item Description: ' . $itemDescription);
        $this->logger->addInfo('Add Item Base Price: ' . $itemBasePrice);

        $itemAddSQL = $this->db->table('item')->insertGetId(
            [
                'name' => $itemName,
                'description' => $itemDescription,
                'image' => $itemImage,
                'base_price' => $itemBasePrice
            ]
        );

		if(!$itemAddSQL) {
			return false;
        }
        
        return true;
    }

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory directory to which the file is moved
     * @param UploadedFile $uploaded file uploaded file to move
     * @return string filename of moved file
     */
    private function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}