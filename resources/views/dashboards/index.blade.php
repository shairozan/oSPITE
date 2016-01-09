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
                <p class="card-stats-title"><i class="mdi-social-group-add"></i> {{ucwords($object)}}</p>
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

@endsection