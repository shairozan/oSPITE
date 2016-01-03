@extends('layouts.master')

@section('content')
    <form method="post" action="{{ action('CharactersController@store') }}" class="form-horizontal">

    <!-- Character information and portrait in this row -->
    <div class="row">
        <div class="col-md-4">
            <div class="input-field">
                <input placeholder="Character Name" id="name" type="text" class="validate">
                <label for="first_name">Character Name</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
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
        </div>

    </div>

    <div class="row">

            <div class="col-md-6">
                <div class="input-field">
                    <textarea id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">Character Notes / Description</label>
                </div>
            </div>

            <div class="col-md-6">

            </div>
    </div>

    </form>


    <script>
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var labels          = $(".label_fields_wrap"); //Labels wrapper
            var values          = $(".value_fields_wrap"); //Values Wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(labels).append('<div id="label_'+ x +'"><input type="text" name="labels[]"/><a id="label_link_' + x + '" href="#" class="remove_field">Remove</a></div>'); //add input box
                    $(values).append('<div id="value_'+ x +'"><input type="text" name="values[]"/><a id="label_link_' + x + '" href="#" class="remove_field" style="color:white">Remove</a><br /></div>');
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
@endsection