@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-4">
            @include('marketing::emails.emails.common.sidebar')
        </div>

        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Emails
                </div>

                <div class="panel-body">
                    <p>
                        Select an email
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop