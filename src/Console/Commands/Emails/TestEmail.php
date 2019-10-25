<?php namespace SamJoyce777\Marketing\Console\Commands\Emails;

use SamJoyce777\Marketing\EmailDispatchers\MandrillEmailDispatcher;
use SamJoyce777\Marketing\Emails\WeeklyBroadband\SocialMedia;
use SamJoyce777\Marketing\Jobs\SendEmail;
use Illuminate\Console\Command;
use SamJoyce777\Marketing\Lists\Emails\Development\Test;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:test {email_address}';

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
        $email = new \SamJoyce777\Marketing\Emails\Development\Test();

        $list_provider = new Test();

        $email_dispatcher = new MandrillEmailDispatcher();

        $email_address = $this->argument('email_address');

        $this->line('Sending test email to ' . $email_address);

        $emailRecipientData = $list_provider->getEmailRecipientData($email_address);
dd($emailRecipientData);
        $email_dispatcher->send($email_address, $emailRecipientData, $email);

        $this->info('Complete.');
    }
}
