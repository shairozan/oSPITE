<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Relatable
{
    protected $table = 'events';
    protected $referenceClass = 'App\Event';
}
