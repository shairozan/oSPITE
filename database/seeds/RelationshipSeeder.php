<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Relationship;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Assign th objects to the campaign

        Relationship::create([
            'campaign_id' => 1,
            'source_type' => 'App\Campaign',
            'source_id' => 1,
            'sibling_type' => 'App\Character',
            'sibling_id' => '1',
        ]);


        Relationship::create([
            'campaign_id' => 1,
            'source_type' => 'App\Campaign',
            'source_id' => 1,
            'sibling_type' => 'App\Character',
            'sibling_id' => 2,
        ]);


        Relationship::create([
            'campaign_id' => 1,
            'source_type' => 'App\Campaign',
            'source_id' => 1,
            'sibling_type' => 'App\Weapon',
            'sibling_id' => 1,
        ]);

        Relationship::create([
            'campaign_id' => 1,
            'source_type' => 'App\Campaign',
            'source_id' => 1,
            'sibling_type' => 'App\Person',
            'sibling_id' => 1
        ]);


        //Relate objects to each other


        Relationship::create([
            'campaign_id' => 1,
            'source_type' => 'App\Weapon',
            'source_id' => 1,
            'sibling_type' => 'App\Character',
            'sibling_id' => '1',
        ]);

        Relationship::create([
            'campaign_id' => 1,
            'source_type' => 'App\Character',
            'source_id' => 1,
            'sibling_type' => 'App\Person',
            'sibling_id' => 1,
        ]);

        Relationship::create([
           'campaign_id' => 1,
            'source_type' => 'App\Character',
            'source_id' => 1,
            'sibling_type' => 'App\Character',
            'sibling_id' => 2,
        ]);
    }
}
