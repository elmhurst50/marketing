<?php namespace SamJoyce777\Marketing\Console\Commands\SMS;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SamJoyce777\LaravelControllerAudit\Models\ConsoleAudit;
use SamJoyce777\Marketing\Jobs\SendSMS;
use SamJoyce777\Marketing\Models\SMS\SMSBlackList;
use SamJoyce777\Marketing\Models\SMS\SMSSent;

class SendList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:sendList {list_identifier} {sms_identifier} {--delay=60}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends all the sms to the list of recipients';

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
        $audit = ConsoleAudit::create(['name' => $this->getName(), 'description' => $this->getDescription()]);

        $sms_identifier = $this->argument('sms_identifier');

        $list_class = config('marketing.lists.sms.' . $this->argument('list_identifier'));

        $this->list = new $list_class;

        $sms_class = config('marketing.sms.' . $sms_identifier);

        $mobile_numbers = $this->list->getList((object)[
            'sms_identifier' => $sms_identifier,
        ]);

        $continue = $this->confirm('There are ' . count($mobile_numbers) . ' mobile numbers. Are you sure you want to continue?');

        if ($continue) {
            foreach ($mobile_numbers as $mobile_number) {
                if(!$this->allowedToSend($mobile_number)){
                    $this->info('************* Not allowed to send to '.$mobile_number. ' *************');
                    continue;
                }

                try {
                    $smsRecipientData = $this->list->getSMSRecipientData($mobile_number);

                    $smsSent = SMSSent::create([
                        'mobile_number' => $mobile_number,
                        'sms_identifier' => $sms_identifier,
                        'sms_class' => $sms_class,
                        'queued_at' => Carbon::now()->toDateTimeString(),
                        'residential_customer_id' => $smsRecipientData->getField('residential_customer_id')
                    ]);

                    $this->line('Attempting dispatch sms to: ' . $mobile_number);

                    SendSMS::dispatch($sms_class, $list_class, $mobile_number, $smsSent->id)
                        ->onQueue('sms')
                        ->delay(now()->addMinutes($this->option('delay')));

                    $this->line('Queued sms to: ' . $mobile_number);
                } catch (\Exception $e) {
                    \Logger::error('sms', 'Could not queue sms to: ' . $mobile_number . ' due to: ' . $e->getMessage());

                    $this->warn('SendList.php Could not send sms to: ' . $mobile_number . ' due to: ' . $e->getMessage());
                }
            }

            $audit->update(['completed_at' => Carbon::now()->toDateTimeString()]);

            $this->info('Complete!');
        } else {
            $this->warn('Aborted!');
        }

    }

    /**
     * Determine if we can send sms to this number
     * @param $mobile_number
     * @return bool
     */
    public function allowedToSend($mobile_number)
    {
        $smsBlackList = SMSBlackList::where('mobile_number', $mobile_number)->first();

        if($smsBlackList) return false;

        return true;
    }
}
