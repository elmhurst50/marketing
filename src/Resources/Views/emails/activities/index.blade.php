@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Email</th>
                    <th class="text-center">Attempted</th>

                    <th class="text-center">Bounced</th>
                    <th class="text-center">Soft Bounce</th>
                    <th class="text-center">Rejected</th>
                    <th class="text-center">Sent</th>

                    <th class="text-center">Spam</th>
                    <th class="text-center">Opened</th>
                    <th class="text-center">Clicked</th>
                </tr>
                </thead>
                <tbody>
                @foreach($email_overview_statistics as $email_overview)
                    <tr>
                        <td title="{!! $email_overview->description !!}">{!! $email_overview->title !!}</td>
                        <td class="text-center">{!! $email_overview->total_attempted !!}</td>

                        <td class="text-center">{!! $email_overview->total_bounced !!}</td>
                        <td class="text-center">{!! $email_overview->total_soft_bounced !!}</td>
                        <td class="text-center">{!! $email_overview->total_rejected !!}</td>
                        <td class="text-center">{!! $email_overview->total_sent !!}</td>

                        <td class="text-center">{!! $email_overview->total_spam !!}</td>
                        <td class="text-center">{!! $email_overview->total_opened !!}</td>
                        <td class="text-center">{!! $email_overview->total_clicked !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop