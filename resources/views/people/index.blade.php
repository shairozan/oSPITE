@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-4">
        <a href="{{action('PeopleController@create')}}" class="btn btn-floating btn-info"><i class="mdi-content-add"></i></a>
    </div>
</div>
<br />

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="characters_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
        $('#characters_table').DataTable({
            ajax: '{!! action('PeopleController@dataTable') !!}'
        });
    });
</script>

@endsection