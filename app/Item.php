<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Item
 *
 */
class Item extends Relatable
{
    protected $table = 'items';


    public function attack(){
        $this->relations =  new Collection();
            $this->relations->add(['this'=>'that']);

    }
}
