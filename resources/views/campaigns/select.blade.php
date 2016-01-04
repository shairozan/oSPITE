@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 card">
            <form method="post" action="{{action('CampaignsController@campaignSwitch')}}">
                {!! csrf_field() !!}
                <select name="campaign_id">
                    @foreach($campaigns as $campaign)
                        <option value="{{$campaign->details->id}}">{{ucwords($campaign->details->name)}}</option>
                    @endforeach
                </select>
                <input type="submit" class="btn btn-info" value="submit" />
            </form>
        </div>
    </div>

@endsection