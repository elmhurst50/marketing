<?php namespace SamJoyce777\Marketing\Console\Commands\Emails;

use Carbon\Carbon;
use SamJoyce777\Marketing\Managers\MandrillManager;
use Illuminate\Console\Command;
use SamJoyce777\LaravelControllerAudit\Models\ConsoleAudit;

class MandrillCheckReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:mandrillCheckReport {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the status of the report';

    protected $mandrill_manager;

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

        $response = $this->mandrill_manager->checkReport($this->argument('id'));

        $audit->update(['completed_at' => Carbon::now()->toDateTimeString()]);

        dd($response);
    }
}
