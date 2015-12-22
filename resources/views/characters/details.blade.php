@extends('layouts.master')

@section('content')



    <br />

    <div class="row">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-image">
                    <img src="{{$character->image}}" style="max-height:100%;max-width:100%;" />
                    <span class="card-title">
                        {{ucwords($character->name)}}
                    </span>
                </div>
                <div class="card-content">
                    {!! $character->notes !!}
                </div>
            </div>
        </div>

        <div class="col-md-6" >

            <!-- Statistics Details Block -->
            <div class="row">
                    <div class="col-xs-12 ">
                        <div class="card">
                            <div class="card-content waves-effect waves-block waves-light blue white-text">
                                <div class="card-title blue white-text">
                                    Statistics
                                </div>
                                <div id="character-graph-holder">
                                    <canvas class="activator" id="characterGraph" ></canvas>
                                </div>
                                <br />
                            </div>

                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4">
                                    Statistics Details
                                    <i class="mdi-navigation-close right"></i>
                                </span>
                                <br />
                                <div class="row">
                                    <table class="table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Stat</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(json_decode($character->stats) as $stat => $value)
                                            <tr>
                                                <td>{{ucwords($stat)}}</td>
                                                <td>{{$value}}</td>
                                            </tr>
                                        @endforeach
                                        </tbodY>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            <!-- Miscellany -->
            <div class="row">
                <div class="col-xs-12">

                    <ul id="projects-collection" class="collection">
                        <li class="collection-item avatar">
                            <i class="mdi-social-person circle light-blue darken-1"></i>
                            <span class="collection-header" style="font-weight:bolder;">Character Details</span>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Race</strong>
                                </div>

                                <div class="col-xs-6">
                                    {{$character->race}}
                                </div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Gender</strong>
                                </div>

                                <div class="col-xs-6">
                                    {{$character->gender}}
                                </div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Alignment</strong>
                                </div>

                                <div class="col-xs-6">
                                    {{$character->alignment}}
                                </div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Level</strong>
                                </div>

                                <div class="col-xs-6">
                                    {{$character->level}}
                                </div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Experience</strong>
                                </div>

                                <div class="col-xs-6">
                                    {{$character->experience or "Not Set"}}
                                </div>
                            </div>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
    </div>

    <hr style="height:10px">

    <div class="row">
        <!-- Relationships -->

    </div>

    {{--*/ $max = count((array)json_decode($character->stats)) - 1 /*--}}
    {{--*/ $counter = 0 /*--}}

    <script>
        var data = {
            labels: [@foreach(json_decode($character->stats) as $stat => $value) "{{$stat}}"@if($counter < $max),@endif  {{--*/ $counter++ /*--}} @endforeach ],
            datasets: [
                {
                    label: "Attributes",
                {{--*/ $counter = 0 /*--}}
                    data: [ @foreach(json_decode($character->stats) as $stat => $value) "{{$value}}"@if($counter < $max),@endif  {{--*/ $counter++ /*--}} @endforeach ]
                }
            ]
        };

        $( document).ready(function(){
            var characterGraph = document.getElementById("characterGraph").getContext("2d");
            var radarChart = new Chart(characterGraph).Radar(data,{
                responsive: "true",
                pointLabelFontColor : "#fff",
            });
        });



    </script>

@endsection