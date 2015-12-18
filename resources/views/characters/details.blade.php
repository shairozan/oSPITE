@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-xs-2 col-md-6 col-lg-4">
            I AM TEH HERO
            <img src="{{$character->image}}" style="max-height:100%;max-width:100%;" />
        </div>

        <div class="col-xs-10 col-md-6 col-lg-8" >
            I AM TEH GRAPH
            <br/>
            @foreach(json_decode($character->stats) as $stat => $value)
                {{$stat}} : {{$value}} <br/>
            @endforeach
        </div>
    </div>

@endsection