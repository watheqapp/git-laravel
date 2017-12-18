<?php

namespace App\Http\Controllers\Api\Models;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="ContactUs"))
 */
class ContactUs
{
    /**
     * @SWG\Property(example="message title")
     * @var string
     */
    public $title;
    
    /**
     * @SWG\Property(example="message content")
     * @var string
     */
    public $content;
    
}