@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-4">
           @include('marketing::emails.emails.common.sidebar')
        </div>

        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Email View
                </div>

                <div class="panel-body">
                    <div style="width:600px; margin: 0 auto; display: block">
                        {!! $html !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop