<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Character;
use App\Relationship;

class CharactersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('characters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('characters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validate request
        $this->validate($request,[
            'name' => 'required|min:5',
            'gender' => 'required',
            'alignment' => 'required',
        ]);

        $character = new Character();

        foreach(\Request::all() as $key=>$value){
            switch($key){
                case '_token':
                    break;

                case '_method':
                    break;

                case 'labels':
                    break;

                case 'values':
                    break;

                default:
                    $character->$key = $value;
            }
        }
        $labels = $request->get('labels');
        $values = $request->get('values');

        //Construct the json array for stats
        foreach($labels as $key=>$value){
            $stats[$value] = $values[$key];
        }

        $character->stats = json_encode($stats);

//        $content = str_ireplace('\r\n', '<br />', $request->get('notes'));
        foreach($request->files as $file){
            $ext = $file->getClientOriginalExtension();
            $name = sha1($file->getClientOriginalName());
            $file->move( storage_path() . '/app/uploads/campaign_' . \Session::get('campaign')->id, $name . '.' . $ext);
            $character->image = \URL::to('/images/' . \Session::get('campaign')->id . '/' . $name . '.' . $ext );
        }


        $character->save();

        //Create the relationship with the Campaign
        $relationship = new Relationship();
        $relationship->campaign_id = \Session::get('campaign')->id;
        $relationship->source_type = 'App\\Campaign';
        $relationship->source_id = \Session::get('campaign')->id;
        $relationship->sibling_type = 'App\\Character';
        $relationship->sibling_id = $character->id;
        $relationship->save();


        return redirect(action('CharactersController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['character'] = Character::find($id);
        $data['character']->fillRelations();
        return view('characters.details')->with($data);


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
        dd(Character::find($id));
    }

    public function dataTable(){

        $characters = \App\Relatable::listAllCampaignObjectsOfType(new \App\Character);

        return \Yajra\Datatables\Datatables::of($characters)
            ->removeColumn('id')
            ->editColumn('name', function($character){
                return '<a class="btn btn-xs btn-info" href="' . \URL::to('/characters/' . $character->id) .'">' . $character->name . '</a>';
            })
            ->removeColumn('notes')
            ->removeColumn('stats')
            ->removeColumn('experience')
            ->removeColumn('level')
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->removeColumn('image')
            ->addColumn('edit',function($character){
                return '<a class="btn btn-xs btn-info" href="' . \URL::to('/characters/' . $character->id . '/edit') .'">Edit</a>';
            })
            ->addColumn('delete',function($character){
                return '<form method="post" action="' . action('CharactersController@destroy',['id'=>$character->id]) . '">
                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="submit" class="btn btn-info" value="Delete"/>
                        </form>';
//                return '<a class="btn btn-xs btn-info" href="' . \URL::to('/characters/' . $character->id . '/delete') .'">Delete</a>';
            })

            ->make();
    }
}
