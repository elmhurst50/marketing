<?php namespace ElmhurstProjects\CommunicationsExampleReal\Console\Commands\Emails;

use ElmhurstProjects\CommunicationsExampleSimple\EmailCreators\Development\TestEmailCreator;
use SamJoyce777\Marketing\EmailCreators\EmailRecipientData;
use Illuminate\Console\Command;
use ElmhurstProjects\CommunicationsExampleSimple\EmailViewData\Development\TestEmailViewData;
use SamJoyce777\Marketing\Managers\Emails\EmailManager;

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
        /*
         *  This is the main email manager that will send the email via chosen dispatcher (ie Mandrill)
         */
        $emailManager = new EmailManager();


        /*
         * This will create the email from the template specified within the class
         */
        $emailCreator = new TestEmailCreator();

        /*
         * This will be in control of the recipient data, such as email address, name, tags
         * ie - All non view content data
         */
        $emailRecipientData = new EmailRecipientData();

        /*
         * This will be control of the data to send to the email creator to generate the view.
         * You can either send in an array from the abstracted method or create the data using
         * the classes unique methods
         */
        $emailViewData = new TestEmailViewData();

        $email_address = $this->argument('email_address');

        $this->line('Sending test email to ' . $email_address);

        $emailRecipientData->setEmailAddress($this->argument('email_address'))->setEmailName('sambo');

        $emailViewData->setViewDataByArray(['name' => 'Mr Test Name']);

        $emailCreator->setViewDataFields($emailViewData);

        $email_sent = $emailManager->sendEmail($emailRecipientData, $emailCreator);

        dd($email_sent);
    }
}
