@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-4">
           @include('marketing::sms.sms.common.sidebar')
        </div>

        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    SMS View
                </div>

                <div class="panel-body">
                    <div style="width:600px; margin: 0 auto; display: block">
                        {!! $message !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop