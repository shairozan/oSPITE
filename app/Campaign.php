<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Campaign
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Relationship[] $relationships
 */
class Campaign extends Model
{
    protected $table = 'campaigns';


    public function relationships (){
        return $this->hasMany('App\Relationship');
    }


    public function meow (){
        $this->relations = new Collection();
        $this->setRelations([
            'meow',
            'meows',
        ]);
    }
}
