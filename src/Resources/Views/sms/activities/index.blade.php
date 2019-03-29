@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>SMS</th>
                    <th class="text-center">Sent</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sms_overview_statistics as $sms_overview)
                    <tr>
                        <td title="{!! $sms_overview->description !!}">{!! $sms_overview->title !!}</td>
                        <td class="text-center">{!! $sms_overview->total_sent !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop