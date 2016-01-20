<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Campaign;
use App\CampaignMembership;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['campaigns'] = CampaignMembership::where('user_id',\Auth::user()->id)->get();

        foreach($data['campaigns'] as $campaign){
            $campaign->details;
        }


        return view('campaigns.select')->with($data);
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

    public function select(){

    }

    public function campaignSwitch(Request $request){

        $campaign = Campaign::find($request->get('campaign_id'));

        \Session::set('campaign',$campaign);

        //Check if we're an admin in the campaign
            $membership = CampaignMembership::where('user_id',\Auth::user()->id)
                ->where('campaign_id',$campaign->id)
                ->first();

            if($membership->is_dm == 1){
                \Session::set('dm',1);
            } else {
                \Session::set('dm',0);
            }

        return redirect(\URL::to('/'));

    }
}
