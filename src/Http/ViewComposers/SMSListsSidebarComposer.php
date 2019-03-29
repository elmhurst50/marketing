<?php

namespace SamJoyce777\Marketing\Http\ViewComposers;

use Illuminate\View\View;

class SMSListsSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $sms_list_categories = config('marketing.lists.sms');

        $view->with('sms_list_categories', $sms_list_categories);
    }
}