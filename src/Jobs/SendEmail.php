<?php

namespace SamJoyce777\Marketing\Jobs;

use Carbon\Carbon;
use SamJoyce777\Marketing\EmailCreators\EmailCreatorInterface;
use SamJoyce777\Marketing\EmailCreators\EmailRecipientData;
use SamJoyce777\Marketing\EmailDispatchers\EmailDispatcherInterface;
use SamJoyce777\Marketing\Managers\Emails\EmailManager;
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

    protected $emailRecipientData;

    protected $emailCreator;

    protected $emailManager;

    /**
     * SendEmail constructor.
     * @param EmailRecipientData $emailRecipientData
     * @param EmailCreatorInterface $emailCreator
     */
    public function __construct(EmailRecipientData $emailRecipientData, EmailCreatorInterface $emailCreator)
    {
        $this->emailRecipientData = $emailRecipientData;

        $this->emailCreator = $emailCreator;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->emailManager = new EmailManager();

        try{
            $this->emailManager->sendEmail($this->emailRecipientData, $this->emailCreator);
        }catch (\Exception $e){
            \Log::error('SendEmail.php - Could not send email to: '
                . $this->emailRecipientData->getEmailAddress()
                . ' Email recipient: '
                . serialize($this->emailRecipientData)
                . ' Email Creator: '
                . serialize($this->emailCreator)
                . ' due to: ' . $e->getMessage());
        }
    }
}
