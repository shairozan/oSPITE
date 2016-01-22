<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CampaignMembership;
use App\Campaign;
use App\Weapon;
use App\Character;
use App\Place;
use App\Time;
use App\Faction;
use App\Relationship;
use App\QuestLog;

class DashboardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaign = \Session::get('campaign');
        $campaign->fillRelations();

        foreach($campaign->getRelations() as $relation){
           foreach($relation as $title=>$components){
               //Split it out into human readable terms
               $pieces = explode('\\',$title);

               $title_component = $pieces[count($pieces) -1];

               $data['objects'][$title_component] = $components;

           }
        }

        $data['campaigns'] = CampaignMembership::where('user_id',\Auth::user()->id)->get();

        foreach($data['campaigns'] as $campaign){
            $campaign->details;
        }

        $data['object_count'] = count($data['objects']);
        $data['columns'] = 5;
        $data['logs'] = QuestLog::where('campaign_id', \Session::get('campaign')->id)
            ->orderBy('id','desc')
            ->get();

        //Let's remove restricted content for non dms
        foreach($data['logs'] as $key => $value){
            foreach($value as $component){
                if( $value->restricted == 1 &&  \Session::get('dm')  == 0 ){
                    unset($data['logs'][$key]);
                }
            }

        }

        return view('dashboards.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
