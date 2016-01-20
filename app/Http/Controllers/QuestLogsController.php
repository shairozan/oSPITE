<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\QuestLog;

class QuestLogsController extends Controller
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
        $this->validate($request,[
            'name'=>'required'
        ]);

        $ql = new QuestLog();
        $ql-> name = $request->get('name');
        $ql->campaign_id = \Session::get('campaign')->id;
        $ql->notes = $request->get('notes');
        if($request->get('restricted') == "on"){
            $ql->restricted = 1;
        } else {
            $ql->restricted = 0;
        }

        $ql->save();
        return redirect(\URL::to('/'));
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
        $data['journal'] = QuestLog::find($id);
        return view('journals.edit')->with($data);
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
            'name'=>'required'
        ]);

        $ql = QuestLog::find($id);

        foreach($request->all() as $key => $value){
                switch($key){
                    case '_token':
                            continue;
                        break;

                    case '_method':
                            continue;
                        break;

                    case 'restricted':
                        if($value == 'on'){
                            $ql->restricted = 1;
                        } else {
                            $ql->restricted = 0;
                        }
                    break;


                    default:
                        $ql->$key = $value;
                }
        }


        $ql->save();
        return redirect(\URL::to('/'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ql = QuestLog::find($id);
        $ql->delete();
        return redirect(\URL::to('/'));
    }
}
