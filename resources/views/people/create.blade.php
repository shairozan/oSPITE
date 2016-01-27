@extends('layouts.master')

@section('content')

    <!-- Include validations -->
    <script type="text/javascript" src="{{asset('js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/jquery-validation/additional-methods.min.js')}}"></script>

    <form id="newWeapon" class="newWeapon" method="post" action="{{ action('PeopleController@store') }}" class="form-horizontal" enctype="multipart/form-data">
    {!! csrf_field() !!}

    <!-- Character information and portrait in this row -->
    <div class="row">
        <div class="col-md-4">

            <div class="input-field">
                <input placeholder="Name" id="name" name="name" type="text" class="validate">
                <label for="first_name">Name <span class="required">*</span> </label>
            </div>

            <input id="restrict_check" type="checkbox" name="restricted">
            <label for="restrict_check">Restricted?</label>


        </div>
    </div>

        <br />
    <div class="row">

            <div class="col-md-6">
                <h4 class="header">Person Notes / Description</h4>
                <textarea id="notes" name="notes">

                </textarea>
            </div>

            <div class="col-md-6">
                <h4 class="header">Image Upload</h4>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" name="image">
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
                }
            },
            //For custom messages
            messages: {
                name:{
                    required: "Please enter the individuals name",
                    minlength: "Individual's name must be more than 5 characters"
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