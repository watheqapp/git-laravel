<?php

namespace App\Http\Controllers\Api\Models\Lawyer;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="LawyerLoginRequest"))
 */
class LawyerLoginRequest {

    /**
     * @SWG\Property(example="0532579547")
     * @var string
     */
    public $phone;

}
