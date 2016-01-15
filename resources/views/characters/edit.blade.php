@extends('layouts.master')

@section('content')

    <!-- Include validations -->
    <script type="text/javascript" src="{{asset('js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/jquery-validation/additional-methods.min.js')}}"></script>

    <form id="editCharacter" class="editCharacter" method="post" action="{{ action('CharactersController@update',['id'=>$character->id]) }}" class="form-horizontal" enctype="multipart/form-data">
    {!! csrf_field() !!}
    {!! method_field('PUT') !!}

    <!-- Character information and portrait in this row -->
    <div class="row">
        <div class="col-md-4">

            <div class="input-field">
                <input placeholder="Character Name" id="name" name="name" type="text" value="{{$character->name or null}}" class="validate">
                <label for="first_name">Character Name <span class="required">*</span> </label>
            </div>

            <div class="input-field">
                <input placeholder="Birthdate" id="birthdate" name="birthdate" value="{{$character->birthdate or null}}" type="text" class="datepicker">
                <label for="birthdate">Birthdate</label>
            </div>

            <div class="input-field">
                <input placeholder="Race" id="race" name="race" type="text" value="{{$character->race or null}}" class="validate">
                <label for="race">Race</label>
            </div>

            <div class="input-field">
                <select id="gender" name="gender" class="validate">
                    <option @if($character->gender == 'Male') selected="selected" @endif>Male</option>
                    <option @if($character->gender == 'Female') selected="selected" @endif>Female</option>
                    <option @if($character->gender == 'Other') selected="selected" @endif>Other</option>
                </select>
                <label for="gender">Gender <span class="required">*</span></label>
            </div>

            <div class="input-field">
                <select id="alignment" name="alignment" class="validate">
                    <option @if($character->alignment == 'Lawful Good') selected="selected" @endif>Lawful Good</option>
                    <option @if($character->alignment == 'Lawful Neutral') selected="selected" @endif>Lawful Neutral</option>
                    <option @if($character->alignment == 'Lawful Evil') selected="selected" @endif>Lawful Evil</option>
                    <option @if($character->alignment == 'Neutral Good') selected="selected" @endif>Neutral Good</option>
                    <option @if($character->alignment == 'True Neutral') selected="selected" @endif>True Neutral</option>
                    <option @if($character->alignment == 'Neutral Evil') selected="selected" @endif>Neutral Evil</option>
                    <option @if($character->alignment == 'Chaotic Good') selected="selected" @endif>Chaotic Good</option>
                    <option @if($character->alignment == 'Chaotic Neutral') selected="selected" @endif>Chaotic Neutral</option>
                    <option @if($character->alignment == 'Chaotic Evil') selected="selected" @endif>Chaotic Evil</option>
                </select>
                <label for="alignment">Alignment <span class="required">*</span></label>
            </div>

            <div class="input-field">
                <input placeholder="Level" id="level" name="level" type="text" value="{{$character->level or null}}" class="validate">
                <label for="level">Level</label>
            </div>

            <div class="input-field">
                <input placeholder="Experience" id="experience" name="experience" type="text" value="{{$character->experience or null}}" class="validate">
                <label for="experience">Experience</label>
            </div>



        </div>


        <div class="col-md-6">
            <!-- Dynamic Stats Shit -->


            @foreach(json_decode($character->stats) as $name=>$value)



            <div class="row">

                <div class="col-md-6">
                    <div><input type="text" name="labels[]" value="{{$name}}" Placeholder="Statistic Name"></div>
                </div>

                <div class="col-md-6">
                    <div><input type="text" name="values[]" value="{{$value}}" Placeholder="Statistic Value"></div>
                </div>
            </div>

            @endforeach
            <!-- End Dynamic Stats Shit -->
        </div>


        <div class="col-md-6">
            <div class="row">
                <br />
                <br />
                <br />
                <button class="add_field_button btn btn-info pull-right">Add More Stats</button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="label_fields_wrap">

                        <div><input type="text" name="labels[]" Placeholder="Statistic Name"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="value_fields_wrap">
                        <div><input type="text" name="values[]" Placeholder="Statistic Value"></div>
                    </div>
                </div>
            </div>
            <!-- End Dynamic Stats Shit -->
        </div>


    </div>

        <br />
    <div class="row">

            <div class="col-md-6">
                <h4 class="header">Character Notes / Description</h4>
                <textarea id="notes" name="notes">
                    {{$character->notes}}
                </textarea>
            </div>

            <div class="col-md-6">
                <h4 class="header">Image Upload (New or Replace)</h4>
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
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var labels          = $(".label_fields_wrap"); //Labels wrapper
            var values          = $(".value_fields_wrap"); //Values Wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = {{$character->statCount}}; //initlal text box count

            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(labels).append('<div id="label_'+ x +'"><input type="text" placeholder="Statistic Name" name="labels[]"/><a id="label_link_' + x + '" href="#" class="remove_field">Remove</a></div>'); //add input box
                    $(values).append('<div id="value_'+ x +'"><input type="text" placeholder="Statistic Value" name="values[]"/><a id="label_link_' + x + '" href="#" class="remove_field" style="color:white">Remove</a><br /></div>');
                }
            });

            $(labels).on("click",".remove_field", function(e){ //user click on remove text
                //First let's get the ID of the object selected
                var selector_string = String(this.id);
                console.log(selector_string);
                var selector_components = selector_string.split("_");
                console.log(selector_components);
                var selector_id = selector_components[selector_components.length-1];
                //Now let's remove both that value and label field

                var label = $("#label_" + selector_id);
                var value = $("#value_" + selector_id);

                label.remove();
                value.remove();
                x--;
            });

//            $(labels).on("click",".remove_field", function(e){ //user click on remove text
//                e.preventDefault(); $(this).parent('div').remove(); x--;
//            })
//
//            $(values).on("click",".remove_field", function(e){ //user click on remove text
//                e.preventDefault(); $(this).parent('div').remove(); x--;
//            })
        });
    </script>

    <script>
        $(document).ready(function(){
            CKEDITOR.replace('notes');
        });
    </script>

    <script>
        $("#editCharacter").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 5
                },
                gender: {
                    required: true
                },
                alignment: {
                    required: true
                }
            },
            //For custom messages
            messages: {
                name:{
                    required: "Please enter a character name",
                    minlength: "Character's name must be more than 5 characers"
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