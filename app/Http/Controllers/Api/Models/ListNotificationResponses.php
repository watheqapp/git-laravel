<?php

namespace App\Http\Controllers\Api\Models;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="ListNotificationResponses"))
 */
class ListNotificationResponses {

    /**
     * @SWG\Property(example="notification content title")
     * @var string
     */
    public $title;

    /**
     * @SWG\Property(example="notification content example")
     * @var string
     */
    public $content;

    /**
     * @SWG\Property(example="NewRequest")
     * @var string
     */
    public $type;
    
    /**
     * @SWG\Property(example="5")
     * @var integer
     */
    public $orderId;
    
    /**
     * @SWG\Property(example="5545454")
     * @var integer
     */
    public $created_at;

}
