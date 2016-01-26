@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6">
        <h4 class="header"> Let's say that</h4>
        <ul class="collection">
            <li class="collection-header"><span class="collection-header"><strong>Source</strong></span></li>
            <li class="collection-item">
                <div class="row">
                    <div class="col-md-3"><strong>Type:</strong></div>
                    <div class="col-md-6"><i>{{$type}}</i></div>
                </div>
            </li>
            <li class="collection-item">
                <div class="row">
                    <div class="col-md-3"><strong>Name:</strong></div>
                    <div class="col-md-6"><i>{{$source->name}}</i></div>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h4 class="header"> Is related to... </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <form method="post" action="{{action('RelationshipsController@store')}}">
            {!! csrf_field() !!}

            <input type="hidden" name="source_type" value="{{$raw_type}}" />
            <input type="hidden" name="source_id" value="{{$source->id}}" />

            <div class="input-field">
                Destination Class:
                <select id="sibling_type" name="sibling_type" class="validate browser-default">
                    <option></option>
                    <option value="App\Character">Character</option>
                    <option value="App\Weapon">Weapon</option>
                    <option value="App\Person">Person</option>
                    <option value="App\Item">Item</option>
                    <option value="App\Place">Place</option>
                    <option value="App\Faction">Faction</option>
                    <option value="App\Time">Time</option>
                </select>
            </div>

            <br />
            <br />

            <div class="input-field">
                Destination Object: <select id="sibling_id" name="sibling_id" class="validate browser-default">

                </select>
            </div>

            <br />
            <br />
            <button class="btn btn-xs purple">Establish Relationship</button>
        </form>
    </div>
</div>

<script>
    $(document).on("change", '#sibling_type', function(e) {
        var type = $(this).val();


        $.ajax({
            type: "GET",
            url: '/existing/' + type,
            dataType: 'json',
            success: function(json) {

                var $el = $("#sibling_id");
                $el.empty(); // remove old options
                $.each(json, function(value, key) {
//                    console.log(key);
                    console.log(key.name);
                    $el.append($("<option></option>")
                            .attr("value", key.id).text(key.name));
                });
            },
            error: function(json) {
                var $el = $("#sibling_id");
                $el.empty();
            }
        });

    });
</script>

@endsection