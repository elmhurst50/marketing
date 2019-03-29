<?php

namespace SamJoyce777\Marketing\Http\Controllers\SMS;

use App\Http\Controllers\Controller;

class ListsController extends Controller
{
    public function index()
    {
        return view('marketing::sms.lists.index');
    }

    public function show($category, $list)
    {
        $list_provider_class = config('marketing.lists.sms.'.$category.'.'.$list);

        $list_provider = new $list_provider_class;

        $sms_list = $list_provider->getList([]);

        return view('marketing::sms.lists.show')->with('sms_list', $sms_list);
    }
}
