<?php

namespace App\Http\Controllers\Api\Models\Lawyer;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="LawyerLoginResponses"))
 */
class LawyerLoginResponses {

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
     * @SWG\Property(example=1)
     * @var boolean
     */
    public $isCompleteProfile;
    
    /**
     * @SWG\Property(example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvY2xpZW50L2xvZ2luIiwiaWF0IjoxNTExNzI2MTkxLCJleHAiOjE1MTE3Mjk3OTEsIm5iZiI6MTUxMTcyNjE5MSwianRpIjoiSXFMck1NTU5sTlNFSVdBayJ9.B765ouFHZLcA1KyRVoDghO3zlvGey8glZ7wxIvL89To")
     * @var string
     */
    public $token;

}
