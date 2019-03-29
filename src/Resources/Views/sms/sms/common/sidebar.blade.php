<div class="panel panel-default">
    <div class="panel-heading">
        Current SMS
    </div>
    <div class="panel-body">
        <ul class="nav nav-stacked">
            @foreach($sms_categories as $category => $smss)
                <li><strong>{!! $category !!}</strong></li>
                @foreach($smss as $identifier => $class)
                    <li>
                        <a href="{!! route('marketing.sms.show', [$category, $identifier]) !!}">
                            {!! $identifier !!}
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</div>