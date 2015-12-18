@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-xs-3 col-md-4 col-lg-2">
            <h1>Portrait</h1>
            <img src="{{$character->image}}" style="max-height:100%;max-width:100%;" />
        </div>

        <div class="col-xs-1 col-md-1 col-lg-2">

        </div>
        <div class="col-xs-8 col-md-7 col-lg-8" >
            <h1> Character Statistics</h1>
            <br />
                <div class="row">
                    <div class="col-xs-6">
                        @foreach(json_decode($character->stats) as $stat => $value)
                            <strong>{{$stat}}</strong> : {{$value}} <br/>
                        @endforeach
                    </div>

                    <div class="col-xs-6">
                        <div id="character-graph-holder">
                            <canvas id="characterGraph" ></canvas>
                        </div>
                        <br />
                    </div>
                </div>
            </div>

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
                responsive: "true"
            });
        });



    </script>

@endsection