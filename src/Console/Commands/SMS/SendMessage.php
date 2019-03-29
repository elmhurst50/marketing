<?php namespace SamJoyce777\Marketing\Console\Commands\SMS;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SamJoyce777\LaravelControllerAudit\Models\ConsoleAudit;
use SamJoyce777\Marketing\Jobs\SendSMS;
use SamJoyce777\Marketing\Managers\SMS\SMSManager;
use SamJoyce777\Marketing\Models\SMS\SMSBlackList;
use SamJoyce777\Marketing\Models\SMS\SMSSent;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:sendMessage {mobile_number} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends message to mobile number (number/message)';

    protected $sms_manager;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sms_manager = new SMSManager();

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

        $this->sms_manager->send($this->argument('mobile_number'), $this->argument('message'));

        $audit->update(['completed_at' => Carbon::now()->toDateTimeString()]);

        $this->info('Message Sent');
    }
}
