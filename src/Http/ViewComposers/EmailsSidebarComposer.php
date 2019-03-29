<?php

namespace SamJoyce777\Marketing\Http\ViewComposers;

use Illuminate\View\View;

class EmailsSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $email_categories = config('marketing.emails');

        $view->with('email_categories', $email_categories);
    }
}