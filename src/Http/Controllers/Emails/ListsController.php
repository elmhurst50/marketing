<?php

namespace SamJoyce777\Marketing\Http\Controllers\Emails;

use App\Http\Controllers\Controller;

class ListsController extends Controller
{
    public function index()
    {
        return view('marketing::emails.lists.index');
    }

    public function show($category, $list)
    {
        $list_provider_class = config('marketing.lists.emails.'.$category.'.'.$list);

        $list_provider = new $list_provider_class;

        $email_list = $list_provider->getList([]);

        return view('marketing::emails.lists.show')->with('email_list', $email_list);
    }
}
