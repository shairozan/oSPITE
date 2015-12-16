<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Character
 *
 */
class Character extends Relatable
{
    protected $referenceClass = 'App\Character';
    protected $table = 'characters';
}
