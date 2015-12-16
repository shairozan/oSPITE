<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Weapon
 *
 */
class Weapon extends Relatable
{
    protected $referenceClass = 'App\Weapon';
    protected $table = 'weapons';
}
