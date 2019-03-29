<?php

namespace SamJoyce777\Marketing\Jobs;

use Carbon\Carbon;
use SamJoyce777\Marketing\Managers\MandrillManager;
use SamJoyce777\Marketing\Models\EmailSent;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DownloadReport implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable, Dispatchable;

    public $tries = 2;

    protected $report_id;

    /**
     * SendEmail constructor.
     * @param $report_id
     */
    public function __construct($report_id)
    {
        $this->report_id = $report_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mandrill_manager = new MandrillManager();

        try{
            $response = $mandrill_manager->checkReport($this->report_id);

            if (isset($response->result_url)) {
                $mandrill_manager->downloadReport($response->result_url);

                $mandrill_manager->insertReport();
            }
        }catch (\Exception $e){
            \Log::error('DownloadReport.php - Could not get report due to: ' . $e->getMessage());
        }
    }
}
