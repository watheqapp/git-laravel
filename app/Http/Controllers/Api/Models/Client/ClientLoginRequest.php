<?php

namespace App\Http\Controllers\Api\Models\Client;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="ClientLoginRequest"))
 */
class ClientLoginRequest {

    /**
     * @SWG\Property(example="966532579547")
     * @var string
     */
    public $phone;

}
