<?php

namespace App\Http\Controllers\Api\Models\Lawyer;

/**
 * @author Ahmad Gamal <eng.asgamal@gamil.com>
 * @SWG\Definition(type="object", @SWG\Xml(name="LawyerUpdateVisibilityRequest"))
 */
class LawyerUpdateVisibilityRequest {

    /**
     * @SWG\Property(enum={0, 1})
     * @var boolean
     */
    public $isOnline;
}
