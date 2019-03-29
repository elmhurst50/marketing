<?php

namespace SamJoyce777\Marketing\Http\Controllers\Emails;

use App\Http\Controllers\Controller;

class EmailsController extends Controller
{
    public function index()
    {
        return view('marketing::emails.emails.index');
    }

    public function show($category, $list)
    {
        $email_provider_class = config('marketing.emails.'.$category.'.'.$list);

        $email_provider = new $email_provider_class;

        $email_template = $email_provider->getTemplate();

        $html = view($email_template)->render();

        return view('marketing::emails.emails.show')->with('html', $html);
    }
}
