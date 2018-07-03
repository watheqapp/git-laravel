<?php

namespace App\Http\Controllers\Api\Models;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="SendSMSRequest"))
 */
class SendSMSRequest
{
    /**
     * @SWG\Property(example="+201200875544")
     * @var string
     */
    public $phone;
    
}