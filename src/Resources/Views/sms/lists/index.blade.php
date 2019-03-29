@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-4">
          @include('marketing::sms.lists.common.sidebar')
        </div>


        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    SMS Lists
                </div>

                <div class="panel-body">
                    <p>
                        Select a list
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop