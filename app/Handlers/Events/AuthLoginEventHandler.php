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



            //Check if we're the DM for this campaign

            if($data['campaigns'][0]->is_dm == 1){
                \Session::set('dm',1);
            } else {
                \Session::set('dm',0);
            }

            \Session::set('campaign',$data['campaigns'][0]->details);
        }
    }
}
