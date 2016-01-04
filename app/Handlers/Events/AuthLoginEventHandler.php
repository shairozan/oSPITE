<?php

namespace App\Handlers\Events;

use App\Events;
use App\CampaignMembership;

class AuthLoginEventHandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle()
    {
        $data['campaigns'] = CampaignMembership::where('user_id',\Auth::user()->id)->get();

        foreach($data['campaigns'] as $campaign){
            $campaign->details;
        }

        if(count($data['campaigns']) >= 1 ){
            \Session::set('campaign',$data['campaigns'][0]->details);
        }
    }
}
