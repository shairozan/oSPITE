@extends('layouts.master')

@section('content')

    <br />

    <div class="row">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-image">
                    <img src="{{$weapon->image or asset('images/vector/tool.svg')}}" style="max-height:100%;max-width:100%;" />
                    <span style="color:dimgrey" class="card-title">
                        {{ucwords($weapon->name)}}
                    </span>
                </div>
                <div class="card-content">
                    {!! $weapon->notes !!}
                </div>
            </div>
        </div>

        <div class="col-md-6" >

            <!-- Miscellany -->
            <div class="row">
                <div class="col-xs-12">

                    <ul id="projects-collection" class="collection">
                        <li class="collection-item avatar">
                            <i class="mdi-social-person circle light-blue darken-1"></i>
                            <span class="collection-header" style="font-weight:bolder;">Weapon Details</span>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Type</strong>
                                </div>

                                <div class="col-xs-6">
                                    {{$weapon->type}}
                                </div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Weapon Damage</strong>
                                </div>

                                <div class="col-xs-6">
                                    {{$weapon->die_quantity}}d{{$weapon->die_sides}}
                                </div>
                            </div>
                        </li>
                    </ul>

                    <a href="/relationships/create/App\Weapon/1" class="btn btn-xs purple waves-effect waves-light">Add a Relationship</a>

                </div>
            </div>
        </div>
    </div>

    <hr style="height:10px">

    <div class="row">
        <div class="col-xs-12">

            <ul id="projects-collection" class="collection">
                <li class="collection-item avatar">
                    <i class="mdi-social-people-outline circle light-blue darken-1"></i>
                    <span class="collection-header" style="font-weight:bolder;">Relationships</span>
                </li>

                <li>

                    <ul class="collapsible popout collapsible-accordion" data-collapsible="accordion">

                        @foreach($weapon->getRelations() as $relationship)
                            @foreach($relationship as $key => $contents)
                                <li>
                                    <div class="collapsible-header">
                                        {{--*/ $components =  explode("\\",$key) /*--}}
                                        <strong>{{$components[count($components) -1]}}</strong>
                                    </div>

                                    <div class="collapsible-body">
                                        @foreach($relationship[$key] as $i)
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <a class="btn waves-effect waves-light indigo"
                                                       href="{{\URL::to('/')}}/@if($components[count($components) -1 ] == 'Person')people/{{$i->id}}"
                                                       @else{{strtolower($components[count($components) -1])}}s/{{$i->id}} @endif "> {{$i->name}} </a>
                                                </div>

                                                <div class="col-md-9">
                                                    {!! $i->notes !!}
                                                </div>
                                            </div>


                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>

                </li>

            </ul>

        </div>
    </div>
@endsection