<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Campaign::create([
            'name'=>'Dawning of the End',
            'active' => 1,
            'summary' => 'Teh awesomeness',
        ]);
    }
}
