<?php namespace SamJoyce777\Marketing\Console\Commands\Emails;

use Carbon\Carbon;
use \SamJoyce777\Marketing\Jobs\SendEmail;
use SamJoyce777\Marketing\Models\EmailBounceList;
use SamJoyce777\Marketing\Models\EmailSent;
use Illuminate\Console\Command;
use SamJoyce777\LaravelControllerAudit\Models\ConsoleAudit;

class UpdateSoftBouncedEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:updateSoftBouncedEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Goes through the emails sent and updates email bounce list that are soft';

    protected $list;

    protected $email;

    public $tries = 5;

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
        $audit = ConsoleAudit::create(['name' => $this->getName(), 'description' => $this->getDescription()]);

        $emails_sent = EmailSent::select('emails_sent.email', 'emails_sent.id')
            ->where('mandrill_status', 'soft-bounced')
            ->where('emails_sent.created_at', '>', Carbon::now()->subMonths(6)->toDateTimeString())
            ->where('email_bounce_list.email', null)
            ->leftJoin('email_bounce_list', 'email_bounce_list.email', '=', 'emails_sent.email')
            ->get();


        foreach ($emails_sent as $email_sent) {
            try{
                $occurrences = EmailSent::where('mandrill_status', 'soft-bounced')
                    ->where('emails_sent.created_at', '>', Carbon::now()->subMonths(6)->toDateTimeString())
                    ->where('email', $email_sent->email)
                    ->count();

                if($occurrences > 2){
                    EmailBounceList::create([
                        'email' => $email_sent->email,
                        'type' => 'soft',
                        'source' => 'Auto update from email sent ID: ' . $email_sent->id
                    ]);
                }

                $this->line($email_sent->email . ' has occurrences '.$occurrences);
            }catch (\Exception $e){
                $this->warn('Could not enter email address '.$email_sent->email);
            }

        }

        $audit->update(['completed_at' => Carbon::now()->toDateTimeString()]);

        $this->info('There are ' . count($emails_sent) . ' soft bounce emails.');
    }
}
