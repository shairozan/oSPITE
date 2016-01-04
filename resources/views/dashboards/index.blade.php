@extends('layouts.master')

@section('content')



    <pre>
        {{\Session::get('campaign')->name}}
    </pre>
@endsection