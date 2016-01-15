@extends('layouts.master')

@section('content')
    {{--*/ $processed = 1 /*--}}

<div id="card-stats" class="seaction">

    <div class="row">



    @foreach( \Config::get('ospite.objects') as $object => $components)

    @if(isset($objects[$object]))
    <div class="col-md-3">
        <div class="card">
            <div class="card-content  {{\Config::get('ospite.objects.' . $object . '.style')}} white-text">
                <p class="card-stats-title"><i class="{{ \Config::get('ospite.objects.' . $object . '.icon')}}"></i>
                    <a class="dashboard" href ="{{ \URL::to('/') . '/' .  strtolower(\Config::get('ospite.objects.' . $object . '.plural')) }}">
                        {{ucwords($object)}}
                    </a></p>
                <h4 class="card-stats-number">{{count($objects[$object])}}</h4>
            </div>
        </div>
    </div>

            {{--*/ $processed += 1 /*--}}

            @if($columns - $processed == 0)

            </div>

            <div clas="row">
                {{--*/ $processed = 1 /*--}}
            @endif

        @endif

    @endforeach

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <ul id="issues-collection" class="collection">
            <li style="background-color: #00BCD4;" class="collection-item avatar">
                <i class="mdi-action-book orange circle"></i>
                <span class="collection-header"><strong style="color:white">Adventure Log</strong></span>
            </li>

            @forelse($logs as $log)

            <li class="collection-item">
                <div class="row">
                    <div class="col-md-4">
                        <p class="collections-title"><a  class="btn btn-xs blue" href="{{action('QuestLogsController@show',['id'=>$log->id])}}">{{$log->name}}</a> </p>
                        <div class="row">
                            <div class="col-md-12">
                                <a  href="{{action('QuestLogsController@edit',['id'=>$log->id])}}" ><span class="task-cat orange">Edit</span></a>
                                <a  href="{{action('QuestLogsController@destroy',['id'=>$log->id])}}" ><span class="task-cat red">Delete</span></a>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        {!! $log->notes !!}
                    </div>
                </div>



            </li>


            @empty
                <br />
            @endforelse


        </ul>
    </div>

        <div class="col-md-4">
            <ul id="task-card" class="collection with-header">
                <li class="collection-header cyan">
                    <h4 class="task-card-title">Log Entry</h4>
                </li>

                <li>
                    <form method="post" action="{{action('QuestLogsController@store')}}" >

                        {!! csrf_field() !!}

                        <div class="input-field">
                            <input placeholder="Log Entry Title" id="name" name="name" type="text" class="validate">
                            <label for="first_name">Title <span class="required">*</span> </label>
                        </div>

                        <h4 class="header"> Log Details </h4>

                        <textarea id="log_entry" name="notes">

                        </textarea>


                        <input id="restrict_check" type="checkbox" name="restricted">
                        <label for="restrict_check">Restricted?</label>

                        <input type="submit" value="Add Entry" class="btn btn-info" />
                    </form>
                </li>
            </ul>
        </div>
</div>



    <script>
        $(document).ready(function(){
        CKEDITOR.replace('notes');
        });
    </script>

@endsection