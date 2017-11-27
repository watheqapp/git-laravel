<?php

namespace App\Http\Controllers\Api\Models;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="Device"))
 */
class Device
{
    /**
     * @SWG\Property(example="D5bj4584545M48lOXq")
     * @var string
     */
    public $identifier;
    
    /**
     * @SWG\Property(example="F5PTn245O3aQ57")
     * @var string
     */
    public $firebaseToken;
    
}