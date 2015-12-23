<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
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



        //Initiate searches and return object of results
        $searchable = [
            'App\Person',
            'App\Character',
            'App\Weapon',
            'App\Item',
            'App\Time',
            'App\Place',
            'App\Faction',
        ];

        foreach($searchable as $object){
                $components = explode('\\',$object);
                $className = strtolower($components[count($components)-1]);

                $hits = $object::where('name', 'like' , '%' . $request->get('name') . '%')->get();
                //Lets supress the HTML laden notes
                foreach($hits as $hit){
                    unset($hit->notes);
                    //set the link for the object
                    $model_components = explode("\\",get_class($hit));
                    $hitClass = strtolower($model_components[count($model_components) -1 ]);

                    if($hitClass == 'person'){
                        $action = 'people';
                    } else {
                        $action = $className . 's';
                    }

                    $hit->link = \URL::to($action . '/' . $hit->id);



                    $results[] = $hit;
                }
        }


        return response()->json($results);
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
