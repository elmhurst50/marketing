<?php namespace SamJoyce777\Marketing\Providers;

use SamJoyce777\Marketing\Console\Commands\Emails\DisplayList;
use SamJoyce777\Marketing\Console\Commands\Emails\ImportEmails;
use SamJoyce777\Marketing\Console\Commands\Emails\MandrillCheckReport;
use SamJoyce777\Marketing\Console\Commands\Emails\MandrillDailyStatistics;
use SamJoyce777\Marketing\Console\Commands\Emails\MandrillDownloadReport;
use SamJoyce777\Marketing\Console\Commands\Emails\MandrillRequestStatistics;
use SamJoyce777\Marketing\Console\Commands\Emails\SendList;
use SamJoyce777\Marketing\Console\Commands\Emails\TestEmail;
use SamJoyce777\Marketing\Console\Commands\Emails\UpdateBouncedEmails;
use SamJoyce777\Marketing\Console\Commands\Emails\UpdateSoftBouncedEmails;
use SamJoyce777\Marketing\Console\Commands\SMS\SendMessage;
use SamJoyce777\Marketing\Http\ViewComposers\EmailsSidebarComposer;
use SamJoyce777\Marketing\Http\ViewComposers\EmailListsSidebarComposer;
use Illuminate\Support\ServiceProvider;
use SamJoyce777\Marketing\Http\ViewComposers\SMSListsSidebarComposer;
use SamJoyce777\Marketing\Http\ViewComposers\SMSSidebarComposer;

class MarketingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'marketing');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../Http/Routes/routes.php';
        }

        view()->composer(['marketing::emails.emails.common.sidebar'], EmailsSidebarComposer::class);

        view()->composer(['marketing::emails.lists.common.sidebar'], EmailListsSidebarComposer::class);

        view()->composer(['marketing::sms.sms.common.sidebar'], SMSSidebarComposer::class);

        view()->composer(['marketing::sms.lists.common.sidebar'], SMSListsSidebarComposer::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                //Emails
                SendList::class,
                TestEmail::class,
                DisplayList::class,
                MandrillRequestStatistics::class,
                MandrillCheckReport::class,
                MandrillDownloadReport::class,
                MandrillDailyStatistics::class,
                ImportEmails::class,
                UpdateBouncedEmails::class,
                UpdateSoftBouncedEmails::class,

                //SMS
                SendMessage::class,
                \SamJoyce777\Marketing\Console\Commands\SMS\DisplayList::class,
                \SamJoyce777\Marketing\Console\Commands\SMS\SendList::class,
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
