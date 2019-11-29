<?php namespace SamJoyce777\Marketing\Managers\Emails;

use Carbon\Carbon;
use SamJoyce777\Marketing\EmailCreators\EmailCreatorInterface;
use SamJoyce777\Marketing\EmailCreators\EmailRecipientData;
use SamJoyce777\Marketing\EmailDispatchers\MandrillEmailDispatcher;
use SamJoyce777\Marketing\Jobs\SendEmail;
use SamJoyce777\Marketing\Models\EmailBlackList;

/**
 * This is the main class to send emails
 * Class EmailManager
 * @package SamJoyce777\Marketing\Managers\Emails
 */
class EmailManager
{
    protected $emailDispatcher;

    protected $emailResponse;

    public function __construct()
    {
        $this->emailDispatcher = new MandrillEmailDispatcher();

        $this->emailResponse = new EmailResponse();
    }

    /**
     * Send the email
     * @param EmailRecipientData $emailRecipientData
     * @param EmailCreatorInterface $emailCreator
     * @return EmailResponse
     */
    public function sendEmail(EmailRecipientData $emailRecipientData, EmailCreatorInterface $emailCreator):EmailResponse
    {
        if(!$this->allowedToSend($emailRecipientData->getEmailAddress())) $this->emailResponse->failed('Not allowed to send to this email address');

        if ($emailCreator->hasAllRequiredData()) {
            $this->emailDispatcher->send($emailRecipientData, $emailCreator);

            return $this->emailResponse->successful();
        }

        return $this->emailResponse->failed('Does not have all the required view data');
    }

    /**
     * Adds the email to the work queue
     * @param EmailRecipientData $emailRecipientData
     * @param EmailCreatorInterface $emailCreator
     * @param Carbon $send_date
     * @return bool
     */
    public function queueEmail(EmailRecipientData $emailRecipientData, EmailCreatorInterface $emailCreator, Carbon $send_date = null)
    {
        if(!$this->allowedToSend($emailRecipientData->getEmailAddress())) return false;

        if(!$send_date) $send_date = Carbon::now();

        SendEmail::dispatch($emailRecipientData, $emailCreator)
            ->onQueue('emails')
            ->delay($send_date);

        return true;
    }

    /**
     * Determine if we can send email to this address
     * @param $email_address
     * @return bool
     */
    public function allowedToSend($email_address)
    {
        $emailBlackList = EmailBlackList::where('email', $email_address)->first();

        if($emailBlackList) return false;

        return true;
    }
}