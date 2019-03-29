<?php namespace SamJoyce777\Marketing\Console\Commands\Emails;

use Carbon\Carbon;
use SamJoyce777\Marketing\Managers\MandrillManager;
use Illuminate\Console\Command;
use SamJoyce777\LaravelControllerAudit\Models\ConsoleAudit;

class MandrillRequestStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:mandrillRequestStatistics {from?} {to?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a report request for set date';

    protected $mandrill_manager;

    public $tries = 5;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->mandrill_manager = new MandrillManager();

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

        $from = ($this->argument('from')) ? Carbon::createFromFormat('Y-m-d', $this->argument('from'))->startOfDay() : Carbon::now()->subDay()->startOfDay();

        $to = ($this->argument('to')) ? Carbon::createFromFormat('Y-m-d', $this->argument('to'))->endOfDay() : Carbon::now()->subDay()->endOfDay();

        $this->line('Requesting report for date range: ' . $from->format('Y-m-d') . ' ' . $to->format('Y-m-d'));

        $response = $this->mandrill_manager->requestActivityReport($from, $to);

        $audit->update(['completed_at' => Carbon::now()->toDateTimeString()]);

        $this->info('Completed request. ID: ' . $response->id);
    }
}
