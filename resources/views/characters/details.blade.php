@extends('layouts.master')

@section('content')



    <br />

    <div class="row">
        <div class="col-xs-5 col-sm-5 col-md-4 col-lg-3 ">
            <div class="card">
                <div class="card-image">
                    <img src="{{$character->image}}" style="max-height:100%;max-width:100%;" />
                    <span class="card-title">
                        {{ucwords($character->name)}}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xs-7 col-sm-7 col-md-8 col-lg-8" >

                <div class="row">
                    <div class="col-md-6 ">
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

                <div class="row">
                    <div class="col-xs-12">
                        <!-- Character notes -->
                        <p>{!! $character->notes !!}</p>
                    </div>
                </div>
            </div>

    </div>

    <div class="row">
        <!-- Relationships -->
        <hr style="height:10px">
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