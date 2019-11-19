<?php namespace ElmhurstProjects\CommunicationsExampleReal\Providers;

use ElmhurstProjects\CommunicationsExampleSimple\Console\Commands\Emails\TestEmail;
use SamJoyce777\Marketing\Http\ViewComposers\EmailsSidebarComposer;
use SamJoyce777\Marketing\Http\ViewComposers\EmailListsSidebarComposer;
use Illuminate\Support\ServiceProvider;
use SamJoyce777\Marketing\Http\ViewComposers\SMSListsSidebarComposer;
use SamJoyce777\Marketing\Http\ViewComposers\SMSSidebarComposer;

class ExampleRealServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'marketing');

        view()->composer(['marketing::emails.emails.common.sidebar'], EmailsSidebarComposer::class);

        view()->composer(['marketing::emails.lists.common.sidebar'], EmailListsSidebarComposer::class);

        view()->composer(['marketing::sms.sms.common.sidebar'], SMSSidebarComposer::class);

        view()->composer(['marketing::sms.lists.common.sidebar'], SMSListsSidebarComposer::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                 TestEmail::class,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
