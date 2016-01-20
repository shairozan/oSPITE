@extends('layouts.master')


@section('content')


<div class="row">
    <div class="col-md-6">
        <ul id="task-card" class="collection with-header">
            <li class="collection-header cyan">
                <h4 class="task-card-title">Log Entry</h4>
            </li>

            <li>
                <form method="post" action="{{action('QuestLogsController@update',['id'=>$journal->id])}}" >

                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}

                    <div class="input-field">
                        <input placeholder="Log Entry Title" id="name" name="name" type="text" value="{{$journal->name or null}}" class="validate">
                        <label for="first_name">Title <span class="required">*</span> </label>
                    </div>

                    <h4 class="header"> Log Details </h4>

                        <textarea id="log_entry" name="notes">
                            {!! $journal->notes or null !!}
                        </textarea>


                    <input id="restrict_check" type="checkbox" name="restricted" @if($journal->restricted) checked="checked" @endif>
                    <label for="restrict_check">Restricted?</label>

                    <input type="submit" value="Update Entry" class="btn btn-info" />
                </form>
            </li>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function(){
        CKEDITOR.replace('notes');
    });
</script>

@endsection