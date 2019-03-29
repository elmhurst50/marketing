@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-4">
            @include('marketing::sms.sms.common.sidebar')
        </div>

        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    SMS
                </div>

                <div class="panel-body">
                    <p>
                        Select an SMS
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop