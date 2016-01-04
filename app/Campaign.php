<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Campaign
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Relationship[] $relationships
 */
class Campaign extends Relatable
{
    protected $table = 'campaigns';
    protected $referenceClass = 'App\Campaign';

    public function relationships (){
        return $this->hasMany('App\Relationship');
    }


    public function users(){
        return $this->hasMany('App\CampaignMembership');
    }


}
