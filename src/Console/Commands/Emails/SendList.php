<?php namespace SamJoyce777\Marketing\Console\Commands\Emails;

use Carbon\Carbon;
use SamJoyce777\Marketing\Managers\Emails\EmailManager;
use Illuminate\Console\Command;
use SamJoyce777\LaravelControllerAudit\Models\ConsoleAudit;
use SamJoyce777\Marketing\Models\EmailSent;

class SendList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendList {list_identifier} {email_identifier} {--days_since_last_email=10000} {--delay=60}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends all the emails to the list of recipients';

    protected $list;

    protected $email;

    protected $email_manager;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->email_manager = new EmailManager();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email_identifier = $this->argument('email_identifier');

        $list_class = config('marketing.lists.emails.' . $this->argument('list_identifier'));

        $this->list = new $list_class;

        $email_addresses = $this->list->getList((object)[
            'email_identifier' => $email_identifier
        ]);

        $sent_email_addresses = EmailSent::whereIn('email', $email_addresses)
            ->where('email_identifier', $email_identifier)
            ->where('sent_at', '>', Carbon::now()->subDays($this->option('days_since_last_email'))->toDateTimeString())
            ->pluck('email')
            ->toArray();

        $valid_email_addresses = $this->removeSentEmailAddresses($sent_email_addresses, $email_addresses);

        $this->info('Number of emails from list: ' . count($email_addresses));
        $this->info('Number of emails that have the email in the last ' . $this->option('days_since_last_email') . ' days: ' . count($sent_email_addresses));
        $this->info('Number of valid emails to send: ' . count($valid_email_addresses));

        $continue = $this->confirm('Are you sure you want to continue?');

        if ($continue) {
            foreach ($valid_email_addresses as $email_address) {
                try {
                    if ($this->email_manager->queueEmail($email_identifier, $list_class, $email_address, $this->option('delay'))) {
                        $this->line('Queued email to: ' . $email_address);
                    } else {
                        $this->warn('Failed to queued email to: ' . $email_address);
                    }
                } catch (\Exception $e) {
                    \Logger::error('email', 'Could not queue email to: ' . $email_address . ' due to: ' . $e->getMessage());

                    $this->warn('SendList.php Could not send email to: ' . $email_address . ' due to: ' . $e->getMessage());
                }
            }

            $this->info('Complete!');
        } else {
            $this->warn('Aborted!');
        }
    }

    /**
     * Removes the sent email addresses from email address list
     * @param $sent_email_addresses
     * @param $email_addresses
     * @return array
     */
    protected function removeSentEmailAddresses($sent_email_addresses, $email_addresses)
    {
        $clean1 = array_diff($sent_email_addresses, $email_addresses);

        $clean2 = array_diff($email_addresses, $sent_email_addresses);

        return array_merge($clean1, $clean2);
    }
}
