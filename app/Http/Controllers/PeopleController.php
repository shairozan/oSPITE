<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Person;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('people.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people.create');
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
        ]);

        $person = new Person();
        $person->created_by = \Auth::user()->id;

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
                        $person->restricted = 1;
                    } else {
                        $person->restricted = 0;
                    }
                    break;

                case 'image':
                    continue;
                    break;

                default:
                    $person->$key = $value;
                    break;

            }
        }


        if( is_a($request->file('image'),UploadedFile::class) ) {

            foreach ($request->files as $file) {
                $person->addFiles($file);
            }
        }

        try {
            $person->save();
            $person->addCampaignMembership();
        } catch (Exception $e) {
            \Log::error('Could not save new Person with name of ' . $person -> name .
                ' . into campaign ID ' . \Session::get('campaign')->id .
                ': Details are as follows: ' . $e->getMessage());
        }

        return redirect(action('PeopleController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['person'] = Person::find($id);
        $data['person']->fillRelations();
        return view('people.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['person'] = Person::find($id);
        return view('people.edit')->with($data);
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
        ]);

        $person = Person::find($id);

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
                        $person->restricted = 1;
                    } else {
                        $person->restricted = 0;
                    }
                    break;

                case 'edit_image':
                    continue;
                    break;

                default:
                    $person->$key = $value;
                    break;

            }
        }

        //First thing, let's clear out any existing files before setting the new one up
        if( is_a($request->file('edit_image'),UploadedFile::class) ) {
            $person->removeFiles();


            foreach ($request->files as $file) {
                $person->addFiles($file);
            }
        }

        try {
            $person->save();
        } catch (Exception $e) {
            \Log::error('Could not save new Person with name of ' . $person -> name .
                ' . into campaign ID ' . \Session::get('campaign')->id .
                ': Details are as follows: ' . $e->getMessage());
        }

        return redirect(action('PeopleController@index'));
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
            $person = Person::find($id);
        } catch (Exception $e){
            \Log::error('Could not locate record: ' . $e->getMessage());
        }

        try {
            $person->delete();
            $person->removeCampaignMembership();
        } catch (Exception $e){
            \Log::error('Could not delete Person ' . $person->name . ': ' . $e->getMessage());
        }

        return redirect(action('PeopleController@index'));
    }
    
    public function dataTable(){
        $people = Person::listAllCampaignObjectsOfType(new \App\Person());

        return \Yajra\Datatables\Datatables::of($people)
            ->removeColumn('id')
            ->removeColumn('created_by')
            ->editColumn('name', function($people){
                return '<a class="btn btn-xs btn-info" href="' . \URL::to('/people/' . $people->id) .'">' . $people->name . '</a>';
            })
            ->removeColumn('notes')
            ->removeColumn('image')
            ->removeColumn('restricted')
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->addColumn('edit',function($people){
                return '<a class="btn btn-xs waves-effect waves-light yellow darken-2" href="' . \URL::to('/people/' . $people->id . '/edit') .'"><i class="mdi-content-create"></i></a>';
            })
            ->addColumn('delete',function($people){
                return '<form method="post" action="' . action('PeopleController@destroy',['id'=>$people->id]) . '">
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
        return Person::all();
    }
}
