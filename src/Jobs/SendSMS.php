<?php

namespace SamJoyce777\Marketing\Jobs;

use Carbon\Carbon;
use SamJoyce777\Marketing\Models\SMS\SMSSent;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSMS implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable, Dispatchable;

    public $tries = 2;

    protected $sms_name;

    protected $sms_class;

    protected $list_class;

    protected $mobile_number;

    protected $sms_sent_id;

    /**
     * SendEmail constructor.
     * @param $sms_class - sms class name
     * @param $list_class - list class name
     * @param $mobile_number - sms address to send to
     * @param $sms_sent_id - sms sent record
     */
    public function __construct($sms_class, $list_class, $mobile_number, $sms_sent_id)
    {
        $this->sms_class = $sms_class;

        $this->list_class = $list_class;

        $this->mobile_number = $mobile_number;

        $this->sms_sent_id = $sms_sent_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sms_provider = new $this->sms_class;

        $list_provider = new $this->list_class;

        try{
            $smsRecipientData = $list_provider->getSMSRecipientData($this->mobile_number);

            $smsSent = SMSSent::find($this->sms_sent_id);

            $sms_provider->send($this->mobile_number, $smsRecipientData);

            if($smsSent) $smsSent->update(['sent_at' => Carbon::now()->toDateTimeString()]);
        }catch (\Exception $e){
            \Log::error('SendSMS.php - Could not send sms to: ' . $this->mobile_number . ' due to: ' . $e->getMessage());
        }
    }
}
