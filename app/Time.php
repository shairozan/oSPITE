<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Relatable
{
    protected $table = 'times';
    protected $referenceClass = 'App\Time';
}
