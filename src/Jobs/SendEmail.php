<?php

namespace SamJoyce777\Marketing\Jobs;

use Carbon\Carbon;
use SamJoyce777\Marketing\Models\EmailSent;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable, Dispatchable;

    public $tries = 2;

    protected $email_name;

    protected $email_class;

    protected $list_class;

    protected $email_address;

    protected $email_sent_id;

    /**
     * SendEmail constructor.
     * @param $email_class - email class name
     * @param $list_class - list class name
     * @param $email_address - email address to send to
     * @param $email_sent_id - email sent record
     */
    public function __construct($email_class, $list_class, $email_address, $email_sent_id)
    {
        $this->email_class = $email_class;

        $this->list_class = $list_class;

        $this->email_address = $email_address;

        $this->email_sent_id = $email_sent_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email_provider = new $this->email_class;

        $list_provider = new $this->list_class;

        try{
            $emailRecipientData = $list_provider->getEmailRecipientData($this->email_address);

            $emailSent = EmailSent::find($this->email_sent_id);

            $email_provider->send($this->email_address, $emailRecipientData, $emailSent);

            if($emailSent) $emailSent->update(['sent_at' => Carbon::now()->toDateTimeString()]);
        }catch (\Exception $e){
            \Log::error('SendEmail.php - Could not send email to: ' . $this->email_address . ' due to: ' . $e->getMessage());
        }
    }
}
