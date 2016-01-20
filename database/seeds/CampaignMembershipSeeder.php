<?php

use Illuminate\Database\Seeder;
use App\CampaignMembership;

class CampaignMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CampaignMembership::create([
            'campaign_id' => 1,
            'user_id' => 1,
            'is_dm' => 1,
            'active' => 1,
        ]);

        CampaignMembership::create([
           'campaign_id' => 1,
            'user_id' => 2,
            'is_dm' => 0,
            'active' => 1,
        ]);
    }
}
