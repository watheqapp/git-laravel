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
     * @SWG\Property(example=1511649843)
     * @var integer
     */
    public $created_at;

    /**
     * @SWG\Property(example=1511649843)
     * @var integer
     */
    public $accepted_at;
}
