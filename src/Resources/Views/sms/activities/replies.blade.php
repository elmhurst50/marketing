@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Mobile Number</th>
                    <th class="text-center">Reply</th>
                </tr>
                </thead>
                <tbody>
                @foreach($smsReplies as $smsReply)
                    <tr>
                        <td>{!! $smsReply->mobile_number !!}</td>
                        <td>{!! $smsReply->reply !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop