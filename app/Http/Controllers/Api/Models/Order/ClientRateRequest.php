<?php

namespace App\Http\Controllers\Api\Models\Order;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="ClientRateRequest"))
 */
class ClientRateRequest {

    /**
     * @SWG\Property(example="3")
     * @var integer
     */
    public $orderId;

    /**
     * @SWG\Property(enum={"1", "2", "3", "4", "5"})
     * @var integer
     */
    public $rate;
}
