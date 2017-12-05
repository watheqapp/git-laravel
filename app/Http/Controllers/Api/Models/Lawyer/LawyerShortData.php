<?php

namespace App\Http\Controllers\Api\Models\Lawyer;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="LawyerShortData"))
 */
class LawyerShortData {

    /**
     * @SWG\Property(example=15)
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(example="Ahmad")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(example="ahmad@gmail.com")
     * @var string
     */
    public $email;

    /**
     * @SWG\Property(example="uploads/ahmad.jpg")
     * @var string
     */
    public $image;

    /**
     * @SWG\Property(example="0532579547")
     * @var string
     */
    public $phone;

    /**
     * @SWG\Property(example=1511649843)
     * @var integer
     */
    public $created_at;

    /**
     * @SWG\Property(example="40.7324319")
     * @var string
     */
    public $latitude;

    /**
     * @SWG\Property(example="42.7324319")
     * @var string
     */
    public $longitude;

}
