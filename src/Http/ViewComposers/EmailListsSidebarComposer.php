<?php

namespace SamJoyce777\Marketing\Http\ViewComposers;

use Illuminate\View\View;

class EmailListsSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $email_list_categories = config('marketing.lists.emails');

        $view->with('email_list_categories', $email_list_categories);
    }
}