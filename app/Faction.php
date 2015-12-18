<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Faction
 *
 */
class Faction extends Relatable
{
    protected $table = 'factions';
    protected $referenceClass = 'App\Faction';
}
