<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Place
 *
 */
class Place extends Relatable
{
    protected $table = 'places';
    protected $referenceClass = 'App\Place';
}
