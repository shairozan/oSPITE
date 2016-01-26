<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Weapon;
use Illuminate\Support\MessageBag;

class WeaponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('weapons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('weapons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'type'=>'required',
            'die_quantity'=>'required|numeric',
            'die_sides' => 'required|numeric',
        ]);

        $weapon = new Weapon();
        $weapon->created_by = \Auth::user()->id;

        foreach($request->all() as $key => $value){
            switch($key){
                case '_method':
                    continue;
                    break;

                case '_token':
                    continue;
                    break;

                case 'restricted':
                    if('value' == 'on'){
                        $weapon->restricted = 1;
                    } else {
                        $weapon->restricted = 0;
                    }
                break;

                default:
                    $weapon->$key = $value;
                    break;

            }
        }

        if($request->has('image')){
            foreach($request->files as $file){
                $ext = $file->getClientOriginalExtension();
                $name = sha1($file->getClientOriginalName());
                $file->move(storage_path() . '/app/uploads/campaign_' . \Session::get('campaign')->id, $name . '.' . $ext);
                $weapon->image = \URL::to('/images/' . \Session::get('campaign')->id . '/' . $name . '.' . $ext);
            }
        }

        try {
            $weapon->save();
            $weapon->addCampaignMembership();
        } catch (Exception $e) {
            \Log::error('Could not save new weapon with name of ' . $weapon -> name .
                ' . into campaign ID ' . \Session::get('campaign')->id .
                ': Details are as follows: ' . $e->getMessage());
        }

        return redirect(action('WeaponsController@index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['weapon'] = Weapon::find($id);
        $data['weapon']->fillRelations();
        return view('weapons.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Check for a valid object
            if(! $data['weapon'] = Weapon::find($id)){
                \Log::error('Couldn\'t locate the requested record: ' . $id);
                $bag = new MessageBag();
                $bag->add('invalid_record','The record you\'re trying to access does not exist.');
                \Session::flash('errors',$bag);
                return redirect(action('WeaponsController@index'));
            }

            return view('weapons.edit')->with($data);

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
        $this->validate($request,[
        'name'=>'required',
            'type'=>'required',
            'die_quantity'=>'required|numeric',
            'die_sides' => 'required|numeric',
        ]);

        $weapon = Weapon::find($id);

        foreach($request->all() as $key => $value){
            switch($key){

                case '_method':
                    continue;
                    break;

                case '_token':
                    continue;
                    break;

                case 'restricted':
                    if('value' == 'on'){
                        $weapon->restricted = 1;
                    } else {
                        $weapon->restricted = 0;
                    }
                    break;

                case 'image':
                    continue;
                    break;

                default:
                    $weapon->$key = $value;
                    break;

            }
        }

            //First thing, let's clear out any existing files before setting the new one up
            $weapon->removeFiles();

            foreach($request->files as $file){
                $weapon->addFiles($file);
            }

        try {
            $weapon->save();
        } catch (Exception $e) {
            \Log::error('Could not save new weapon with name of ' . $weapon -> name .
                ' . into campaign ID ' . \Session::get('campaign')->id .
                ': Details are as follows: ' . $e->getMessage());
        }

        return redirect(action('WeaponsController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
           $weapon = Weapon::find($id);
        } catch (Exception $e){
            \Log::error('Could not locate record: ' . $e->getMessage());
        }

        try {
            $weapon->delete();
            $weapon->removeCampaignMembership();
        } catch (Exception $e){
            \Log::error('Could not delete weapon ' . $weapon->name . ': ' . $e->getMessage());
        }

        return redirect(action('WeaponsController@index'));

    }

    public function dataTable(){
        $weapons = Weapon::listAllCampaignObjectsOfType(new \App\Weapon());

        return \Yajra\Datatables\Datatables::of($weapons)
            ->removeColumn('id')
            ->removeColumn('created_by')
            ->editColumn('name', function($weapon){
            return '<a class="btn btn-xs btn-info" href="' . \URL::to('/weapons/' . $weapon->id) .'">' . $weapon->name . '</a>';
            })
            ->removeColumn('notes')
            ->removeColumn('die_quantity')
            ->removeColumn('die_sides')
            ->removeColumn('image')
            ->removeColumn('restricted')
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->addColumn('edit',function($weapon){
                return '<a class="btn btn-xs waves-effect waves-light yellow darken-2" href="' . \URL::to('/weapons/' . $weapon->id . '/edit') .'"><i class="mdi-content-create"></i></a>';
            })
            ->addColumn('delete',function($weapon){
                return '<form method="post" action="' . action('WeaponsController@destroy',['id'=>$weapon->id]) . '">
                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="btn btn-xs waves-effect waves-light red">
                                <i class="mdi-action-delete"></i>
                            </button>
                        </form>';
//                return '<a class="btn btn-xs btn-info" href="' . \URL::to('/characters/' . $character->id . '/delete') .'">Delete</a>';
            })
            ->make();
    }

    public function testIndex(){
        return Weapon::all();
    }
}
