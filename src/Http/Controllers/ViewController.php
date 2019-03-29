<?php

namespace SamJoyce777\Marketing\Http\Controllers;

use App\Http\Controllers\Controller;
use SamJoyce777\Marketing\Models\EmailBlackList;
use SamJoyce777\Marketing\Models\EmailSent;

class ViewController extends Controller
{
    public function show($view)
    {
        $html = view('emails::' . $view)->with('unique_token', 'yustuisgkshgkjhskghksjg')->render();

        return view('emails::view')->with('html', $html);
    }

    public function unsubscribe($unique_token)
    {
        $emailSent = EmailSent::where('unique_token', $unique_token)->first();

        if ($emailSent) {
            EmailBlackList::updateOrCreate([
                'email' => $emailSent->email
            ], [
                'email' => $emailSent->email,
                'reason' => 'Unsubscribe link clicked on email ID: ' . $emailSent->id,
                'source' => ''
            ]);

            $emailSent->update(['unsubscribe_clicked' => true]);

            \Session::flash('success', 'Your email un-subscribe request has been successful. You will no longer receive marketing emails from us.');

            \Logger::info('emails', 'Unsubscribe requested for email ID: '.$emailSent->id);
        } else {
            \Session::flash('error', 'There was an error. We could not find token ' . $unique_token);

            \Logger::info('emails', 'Unsubscribe error for unique token: '.$unique_token);
        }

        return redirect()->route('website.home');
    }
}
