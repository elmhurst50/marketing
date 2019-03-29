<?php

namespace SamJoyce777\Marketing\Http\ViewComposers;

use Illuminate\View\View;

class SMSSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $sms_categories = config('marketing.sms');

        $view->with('sms_categories', $sms_categories);
    }
}