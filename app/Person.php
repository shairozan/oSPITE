<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Person
 *
 */
class Person extends Relatable
{
    protected $table = 'people';
    protected $referenceClass = 'App\Person';
}
