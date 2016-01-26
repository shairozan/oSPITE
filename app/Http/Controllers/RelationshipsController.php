<?php

namespace App\Http\Controllers;

use App\Relationship;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Relatable;
use Illuminate\Support\MessageBag;


class RelationshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //Make sure we're not doing something stupid like
        //mapping ourself to ourselves
        $source = $request->get('source_type') . $request->get('source_id');
        $dest = $request->get('sibling_type') . $request->get('sibling_id');

        if($source == $dest){
            //Stupid! You can't do that
            $bag = new MessageBag();
            $bag->add('invalid_operation','You are trying to relate an object to itself! That\'s not smart!');
            \Session::flash('errors',$bag);
            return redirect ('/');
        }

        $relationship = new Relationship();
        $relationship->campaign_id = \Session::get('campaign')->id;
        $relationship->source_type = $request->get('source_type');
        $relationship->source_id = $request->get('source_id');
        $relationship->sibling_type = $request->get('sibling_type');
        $relationship->sibling_id = $request->get('sibling_id');

        try{
            $relationship->save();
        } catch (Exception $e){
            \Log::error('Unable to save relationship between ' . $request->get('source_type')
             . ": "
            . $request->get('source_id')
            . 'And '
            . $request->get('sibling_type')
            . ":"
            . $request->get('sibling_id'));
        }

        return redirect ('/');

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

    public function map($source_class,$source_id){
        $components = explode("\\",$source_class);
        $data['type'] = $components[count($components) -1 ];
        $data['raw_type'] = $source_class;
        $data['source'] = $source_class::find($source_id);
        return view('relationships.create')->with($data);
    }

    public function objectList($class){
        return Relatable::listAllCampaignObjectsOfType($class)->get();
    }

}
