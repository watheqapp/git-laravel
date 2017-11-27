<?php

namespace App\Http\Controllers\Api\Models;

/**
 * @author Ahmad Gamal <ahmed.gamal@ibtikar.net.sa>
 * @SWG\Definition(type="object", @SWG\Xml(name="RemoveDevice"))
 */
class RemoveDevice
{
    /**
     * @SWG\Property(example="D5bj4584545M48lOXq")
     * @var string
     */
    public $identifier;
    
}