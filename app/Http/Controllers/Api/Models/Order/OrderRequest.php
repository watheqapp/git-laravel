<?php

namespace App\Http\Controllers\Api\Models\Order;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="OrderRequest"))
 */
class OrderRequest {

    /**
     * @SWG\Property(example="3")
     * @var integer
     */
    public $categoryId;

    /**
     * @SWG\Property(enum={"home", "office"})
     * @var string
     */
    public $delivery;
    
    /**
     * @SWG\Property(example="Mostafa shady")
     * @var string
     */
    public $clientName;
    
    /**
     * @SWG\Property(example="Khaled senawy")
     * @var string
     */
    public $representativeName;
    
    /**
     * @SWG\Property(example="1458787878")
     * @var string
     */
    public $clientNationalID;
    
    /**
     * @SWG\Property(example="18587887878")
     * @var string
     */
    public $representativeNationalID;
    
    /**
     * @SWG\Property(example="1533")
     * @var string
     */
    public $letterNumber;
    
    /**
     * @SWG\Property(example="12-6-2018")
     * @var string
     */
    public $letterDate;
    
    /**
     * @SWG\Property(example="12-6-2017")
     * @var string
     */
    public $marriageDate;
    
    /**
     * @SWG\Property(example="15:60")
     * @var string
     */
    public $marriageTime;

    /**
     * @SWG\Property(example="23 alex st.")
     * @var string
     */
    public $address;

    /**
     * @SWG\Property(example="5 hours")
     * @var string
     */
    public $time;

    /**
     * @SWG\Property(example="15 kilometer")
     * @var string
     */
    public $distance;

    /**
     * @SWG\Property(example="31.217951")
     * @var string
     */
    public $latitude;

    /**
     * @SWG\Property(example="29.942465")
     * @var string
     */
    public $longitude;

}
