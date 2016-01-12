@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="characters_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Race</th>
                    <th>Gender</th>
                    <th>Alignment</th>
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
            ajax: '{!! action('CharactersController@dataTable') !!}'
        });
    });
</script>

@endsection