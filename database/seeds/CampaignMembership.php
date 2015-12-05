<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
        App\CampaignMembership::create([
            'user_id' => 1,
            'campaign_id' => 1,
            'is_dm' => 1,
            'active' => 1,
        ]);
    }
}
