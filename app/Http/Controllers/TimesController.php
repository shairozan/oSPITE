<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Time;

//Required to check for class existance without full namespace in update
use Symfony\Component\HttpFoundation\File\UploadedFile;


class TimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('times.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('times.create');
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

        $time = new Time();
        $time->created_by = \Auth::user()->id;

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
                        $time->restricted = 1;
                    } else {
                        $time->restricted = 0;
                    }
                    break;

                case 'image':
                    continue;
                    break;

                default:
                    $time->$key = $value;
                    break;

            }
        }


        if( is_a($request->file('image'),UploadedFile::class) ) {

            foreach ($request->files as $file) {
                $time->addFiles($file);
            }
        }

        try {
            $time->save();
            $time->addCampaignMembership();
        } catch (Exception $e) {
            \Log::error('Could not save new Time with name of ' . $time -> name .
                ' . into campaign ID ' . \Session::get('campaign')->id .
                ': Details are as follows: ' . $e->getMessage());
        }

        return redirect(action('TimesController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['time'] = Time::find($id);
        $data['time']->fillRelations();
        return view('times.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['time'] = Time::find($id);
        return view('times.edit')->with($data);
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

        $time = Time::find($id);

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
                        $time->restricted = 1;
                    } else {
                        $time->restricted = 0;
                    }
                    break;

                case 'edit_image':
                    continue;
                    break;

                default:
                    $time->$key = $value;
                    break;

            }
        }

        //First thing, let's clear out any existing files before setting the new one up
        if( is_a($request->file('edit_image'),UploadedFile::class) ) {
            $time->removeFiles();


            foreach ($request->files as $file) {
                $time->addFiles($file);
            }
        }

        try {
            $time->save();
        } catch (Exception $e) {
            \Log::error('Could not save new Time with name of ' . $time -> name .
                ' . into campaign ID ' . \Session::get('campaign')->id .
                ': Details are as follows: ' . $e->getMessage());
        }

        return redirect(action('TimesController@index'));
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
            $time = Time::find($id);
        } catch (Exception $e){
            \Log::error('Could not locate record: ' . $e->getMessage());
        }

        try {
            $time->delete();
            $time->removeCampaignMembership();
            $time->removeFiles();
        } catch (Exception $e){
            \Log::error('Could not delete Time ' . $time->name . ': ' . $e->getMessage());
        }

        return redirect(action('TimesController@index'));
    }

    public function dataTable(){
        $times = Time::listAllCampaignObjectsOfType(new \App\Time());

        return \Yajra\Datatables\Datatables::of($times)
            ->removeColumn('id')
            ->removeColumn('created_by')
            ->editColumn('name', function($times){
                return '<a class="btn btn-xs btn-info" href="' . \URL::to('/times/' . $times->id) .'">' . $times->name . '</a>';
            })
            ->removeColumn('notes')
            ->removeColumn('image')
            ->removeColumn('restricted')
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->addColumn('edit',function($times){
                return '<a class="btn btn-xs waves-effect waves-light yellow darken-2" href="' . \URL::to('/times/' . $times->id . '/edit') .'"><i class="mdi-content-create"></i></a>';
            })
            ->addColumn('delete',function($times){
                return '<form method="post" action="' . action('TimesController@destroy',['id'=>$times->id]) . '">
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
        return Time::all();
    }
    
}
