@extends('marketing::layouts.main')

@section('content')
    <div class="row">
        <div class="col-xs-4">
            @include('marketing::emails.lists.common.sidebar')
        </div>


        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Email Addresses
                </div>

                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        @foreach($email_list as $email)
                            <tr>
                                <td>
                                    {!! $email !!}
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