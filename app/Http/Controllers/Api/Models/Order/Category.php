<?php

namespace App\Http\Controllers\Api\Models\Order;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="Category"))
 */
class Category {

    /**
     * @SWG\Property(example="Powers of attorney")
     * @var integer
     */
    public $name;

    /**
     * @SWG\Property(example={"Powers of attorney description"})
     * @var string
     */
    public $discription;

    /**
     * @SWG\Property(example="400")
     * @var string
     */
    public $cost;

}
