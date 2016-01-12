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
    <div class="col-lg-4">
        <ul id="issues-collection" class="collection">
            <li class="collection-item avatar">
                <i class="mdi-action-book orange circle"></i>
                <span class="collection-header">Adventure Log</span>
                <p><a href="#">Events so far...</a></p>
            </li>


            <li class="collection-item">
                <div class="row">
                    <div class="col-md-3">
                        <p class="collections-title"><strong>Log Entry:</strong></p>
                        <br />
                        <p><i>Enter the group...</i></p>
                    </div>
                    <div class="col-md-9">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer scelerisque tempus aliquam. Suspendisse potenti. Etiam quis aliquet purus. Vestibulum vulputate blandit mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin commodo odio luctus nunc volutpat sollicitudin. Nulla non sollicitudin mi. Sed sed mi dictum, pretium ligula ornare, volutpat eros. Nunc non nulla elementum, viverra justo fermentum, aliquam orci. Ut sed vulputate nisl, ut feugiat velit. Proin sit amet arcu vel elit egestas elementum ut id nisl. </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p  style="font-weight: bold;" class="collections-title">Tags</p>
                    </div>
                </div>
                <div class="row">
                    <p class="collections-content">
                        <span class="task-cat deep-purple">Introduction</span>
                        <!-- For each tag, check if color is defined. If so, set the background color dynamically -->
                        <span class="task-cat" style="background-color:#fff59d;">Combat</span>
                    <span class="task-cat" style="background-color: orangered;">Romance</span>
                    </p>
                </div>
            </li>





            <li class="collection-item">
                <div class="row">
                    <div class="col s7">
                        <p class="collections-title"><strong>#108</strong> API Fix</p>
                        <p class="collections-content">API Project </p>
                    </div>
                    <div class="col s2">
                        <span class="task-cat yellow darken-4">P2</span>
                    </div>
                    <div class="col s3">
                        <div class="progress">
                            <div class="determinate" style="width: 40%"></div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="collection-item">
                <div class="row">
                    <div class="col s7">
                        <p class="collections-title"><strong>#205</strong> Profile page css</p>
                        <p class="collections-content">New Project </p>
                    </div>
                    <div class="col s2">
                        <span class="task-cat light-green darken-3">P3</span>
                    </div>
                    <div class="col s3">
                        <div class="progress">
                            <div class="determinate" style="width: 95%"></div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="collection-item">
                <div class="row">
                    <div class="col s7">
                        <p class="collections-title"><strong>#188</strong> SAP Changes</p>
                        <p class="collections-content">SAP Project</p>
                    </div>
                    <div class="col s2">
                        <span class="task-cat pink accent-2">P1</span>
                    </div>
                    <div class="col s3">
                        <div class="progress">
                            <div class="determinate" style="width: 10%"></div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

@endsection