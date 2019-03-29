<?php namespace SamJoyce777\Marketing\Console\Commands\Emails;

use SamJoyce777\Marketing\Emails\WeeklyBroadband\SocialMedia;
use SamJoyce777\Marketing\Jobs\SendEmail;
use Illuminate\Console\Command;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:test {email_identifier?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email';

    protected $list;

    protected $email;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email_class = ($this->argument('email_identifier') != '')
            ? config('marketing.emails.' . $this->argument('email_identifier'))
            : config('marketing.emails.development.test');

        $list_class = config('marketing.lists.emails.development.test');

        $list_provider = new $list_class;

        foreach ($list_provider->getList((object)[]) as $email) {
            $this->line('Sending test email to ' . $email);

            SendEmail::dispatch($email_class, $list_class, $email, 666)
                ->onQueue('emails')
                ->delay(now()->addSeconds(10));
        }

        $this->info('Complete.');
    }
}
