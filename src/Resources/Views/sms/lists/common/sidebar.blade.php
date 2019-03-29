<div class="panel panel-default">
    <div class="panel-heading">
        Current Lists
    </div>
    <div class="panel-body">
        <ul class="nav nav-stacked">
            @foreach($sms_list_categories as $category => $lists)
                <li><strong>{!! $category !!}</strong></li>
                @foreach($lists as $identifier => $class)
                    <li>
                        <a href="{!! route('marketing.sms.lists.show', [$category, $identifier]) !!}">
                            {!! $identifier !!}
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</div>