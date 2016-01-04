<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CampaignMembership
 *
 */
class CampaignMembership extends Model
{
    public function details(){
        return $this->belongsTo('App\Campaign','campaign_id');
    }
}
