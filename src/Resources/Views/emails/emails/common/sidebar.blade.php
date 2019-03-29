<div class="panel panel-default">
    <div class="panel-heading">
        Current Emails
    </div>
    <div class="panel-body">
        <ul class="nav nav-stacked">
            @foreach($email_categories as $category => $emails)
                <li><strong>{!! $category !!}</strong></li>
                @foreach($emails as $identifier => $class)
                    <li>
                        <a href="{!! route('marketing.emails.show', [$category, $identifier]) !!}">
                            {!! $identifier !!}
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</div>