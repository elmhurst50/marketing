<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>View Email List</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li><a href="{!! route('marketing.emails') !!}">Emails</a></li>
                <li><a href="{!! route('marketing.emails.lists') !!}">Email Lists</a></li>
                <li><a href="{!! route('marketing.emails.activities', [\Carbon\Carbon::now()->format('Y-m-d'), \Carbon\Carbon::now()->format('Y-m-d')]) !!}">Email Activity</a></li>

                <li><a href="{!! route('marketing.sms') !!}">SMS</a></li>
                <li><a href="{!! route('marketing.sms.lists') !!}">SMS Lists</a></li>
                <li><a href="{!! route('marketing.sms.activities', [\Carbon\Carbon::now()->format('Y-m-d'), \Carbon\Carbon::now()->format('Y-m-d')]) !!}">SMS Activity</a></li>
                <li><a href="{!! route('marketing.sms.replies', [\Carbon\Carbon::now()->format('Y-m-d'), \Carbon\Carbon::now()->format('Y-m-d')]) !!}">SMS Replies</a></li>

            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>