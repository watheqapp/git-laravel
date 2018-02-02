<?php

namespace App\Http\Controllers\Api\Models\Order;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="OrderResponses"))
 */
class OrderResponses {

    /**
     * @SWG\Property(example={"New"})
     * @var string
     */
    public $status;

    /**
     * @SWG\Property(example={"120"})
     * @var string
     */
    public $cost;

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
     * @SWG\Property(example="40.7324319")
     * @var string
     */
    public $clientLat;

    /**
     * @SWG\Property(example="42.7324319")
     * @var string
     */
    public $clientLong;

    /**
     * @SWG\Property(@SWG\Xml(name="Category", wrapped=true))
     * @var Category[]
     */
    public $category;

    /**
     * @SWG\Property(@SWG\Xml(name="LawyerShortData", wrapped=true))
     * @var LawyerShortData[]
     */
    public $lawyer;
    
    /**
     * @SWG\Property(enum={1, 0})
     * @var integer
     */
    public $isInAcceptLawyerPeriod;

    /**
     * @SWG\Property(example=1511649843)
     * @var integer
     */
    public $created_at;

    /**
     * @SWG\Property(example=1511649843)
     * @var integer
     */
    public $accepted_at;
    
    /**
     * @SWG\Property(example=15511649843)
     * @var integer
     */
    public $closed_at;
}
