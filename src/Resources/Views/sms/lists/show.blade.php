@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-4">
            @include('marketing::sms.lists.common.sidebar')
        </div>


        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    SMS Mobile Numbers
                </div>

                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        @foreach($sms_list as $mobile_number)
                            <tr>
                                <td>
                                    {!! $mobile_number !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop