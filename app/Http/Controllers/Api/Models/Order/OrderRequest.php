<?php

namespace App\Http\Controllers\Api\Models\Order;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="OrderRequest"))
 */
class OrderRequest {

    /**
     * @SWG\Property(example="1")
     * @var integer
     */
    public $categoryId;

    /**
     * @SWG\Property(enum={"home", "office"})
     * @var string
     */
    public $delivery;

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
