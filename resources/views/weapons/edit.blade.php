@extends('layouts.master')

@section('content')

    <!-- Include validations -->
    <script type="text/javascript" src="{{asset('js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/jquery-validation/additional-methods.min.js')}}"></script>

    <form id="newWeapon" class="newWeapon" method="post" action="{{ action('WeaponsController@update',['id'=>$weapon->id]) }}" class="form-horizontal" enctype="multipart/form-data">
    {!! csrf_field() !!}
            {!! method_field('PUT') !!}

    <!-- Character information and portrait in this row -->
    <div class="row">
        <div class="col-md-4">

            <div class="input-field">
                <input value="{{$weapon->name or null}}" id="name" name="name" type="text" class="validate">
                <label for="first_name">Weapon Name <span class="required">*</span> </label>
            </div>

            <div class="input-field">
                <input value="{{$weapon->type or null}}" id="type" name="type" type="text">
                <label for="type">Type <span class="required">*</span></label>
            </div>

            <div class="input-field">
                <input value="{{$weapon->die_quantity or null}}" id="die_quantity" name="die_quantity" type="text" class="validate">
                <label for="die_quantity">Die Number <span class="required">*</span></label>
            </div>

            <div class="input-field">
                <input value="{{$weapon->die_sides or null}}" id="die_sides" name="die_sides" type="text" class="validate">
                <label for="die_sides">Die Sides <span class="required">*</span></label>
            </div>

            <input id="restrict_check" type="checkbox" name="restricted" @if($weapon->restricted == 1) checked="checked" @endif>
            <label for="restrict_check">Restricted?</label>


        </div>

        <div class="col-md-2"></div>

        <div class="col-md-4">
        </div>



    </div>

        <br />
    <div class="row">

            <div class="col-md-6">
                <h4 class="header">Weapon Notes / Description</h4>
                <textarea id="notes" name="notes">
                    {!! $weapon->notes or null !!}
                </textarea>
            </div>

            <div class="col-md-6">
                <h4 class="header">Image Upload</h4>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" name="edit_image">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </div>

    </div>

        <input id="submit" type="submit" class="btn btn-info" />
    </form>


    <script>
        $(document).ready(function(){
            CKEDITOR.replace('notes');
        });
    </script>

    <script>
        $("#newWeapon").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 5
                },
                type: {
                    required: true
                },
                die_quantity: {
                    required: true,
                    number: true
                },
                die_sides: {
                    required: true,
                    number: true
                }
            },
            //For custom messages
            messages: {
                name:{
                    required: "Please enter a weapon name",
                    minlength: "Weapon's name must be more than 5 characers"
                },
                type: {
                    required: "You must provide a type for this weapon"
                },
                die_number: {
                    required: "You must provide a number of die pertaining to the weapon's damage",
                    number: "This field only accepts integer inputs"
                },
                die_quantity: {
                    required: "You must provide a number of sides on a die pertaining to the weapon's damage",
                    number: "This field only accepts integer inputs"
                }
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });
    </script>
@endsection