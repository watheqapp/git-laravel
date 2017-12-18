<?php

namespace App\Http\Controllers\Api\Models;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="ListSocialResponses"))
 */
class ListSocialResponses {

    /**
     * @SWG\Property(example="https://fb.com/watheq")
     * @var string
     */
    public $facebook;

    /**
     * @SWG\Property(example="https://twitter.com/watheq")
     * @var string
     */
    public $twitter;

    /**
     * @SWG\Property(example="https://plus.com/watheq")
     * @var string
     */
    public $google;

}
