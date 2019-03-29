<?php namespace SamJoyce777\Marketing\Console\Commands\SMS;

use Carbon\Carbon;
use \SamJoyce777\Marketing\Jobs\SendEmail;
use SamJoyce777\Marketing\Models\SMSSent;
use Illuminate\Console\Command;
use SamJoyce777\LaravelControllerAudit\Models\ConsoleAudit;

class DisplayList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:displayList {list_identifier} {sms_identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays the SMS of the list';

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

        $mobile_numbers = $this->list->getList((object)[
            'sms_identifier' => $sms_identifier
        ]);

        foreach ($mobile_numbers as $mobile_number) {
            $this->line($mobile_number);
        }

        $audit->update(['completed_at' => Carbon::now()->toDateTimeString()]);

        $this->info('There are ' . count($mobile_numbers) . ' mobile numbers.');
    }
}
