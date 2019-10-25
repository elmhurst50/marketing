<?php

namespace SamJoyce777\Marketing\Jobs;

use Carbon\Carbon;
use SamJoyce777\Marketing\Models\EmailSent;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * This job is in charge of sending the email
 * Class SendEmail
 * @package SamJoyce777\Marketing\Jobs
 */
class SendEmail implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable, Dispatchable;

    public $tries = 2;

    protected $email_name;

    protected $email_class;

    protected $email_dispatcher_class;

    protected $list_class;

    protected $email_address;

    /**
     * SendEmail constructor.
     * @param $email_dispatcher_class - email dispatcher class name
     * @param $email_class - email class name
     * @param $list_class - list class name
     * @param $email_address - email address to send to
     */
    public function __construct(string $email_dispatcher_class, string $email_class, string $list_class, string $email_address)
    {
        $this->email_dispatcher_class = $email_dispatcher_class;

        $this->email_class = $email_class;

        $this->list_class = $list_class;

        $this->email_address = $email_address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new $this->email_class;

        $list_provider = new $this->list_class;

        $email_dispatcher = new $this->email_dispatcher_class;

        try{
            $emailRecipientData = $list_provider->getEmailRecipientData($this->email_address);

            $email_dispatcher->send($this->email_address, $emailRecipientData, $email);
        }catch (\Exception $e){
            \Log::error('SendEmail.php - Could not send email to: ' . $this->email_address . ' due to: ' . $e->getMessage());
        }
    }
}
