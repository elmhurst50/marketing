<?php namespace SamJoyce777\Marketing\EmailDispatchers;

use Carbon\Carbon;
use SamJoyce777\Marketing\Emails\EmailInterface;
use SamJoyce777\Marketing\Lists\Emails\EmailRecipientData;
use SamJoyce777\Marketing\Models\EmailSent;

/**
 * Is in charge of creating and sending an email
 * Class Email
 * @package SamJoyce777\Marketing\Emails
 */
abstract class EmailDispatcherAbstract
{
    /**
     * @param string $email_address
     * @param EmailRecipientData $emailRecipientData
     * @param EmailInterface $email
     * @return EmailSent
     */
   protected function recordEmailInDatabase(string $email_address, EmailRecipientData $emailRecipientData, EmailInterface $email):EmailSent
   {
       return EmailSent::create([
            'email_address' => $email_address,
            'email_class' => get_class($email),
            'queued_at' => Carbon::now()->toDateTimeString(),
            'recipient_reference_uid' => $emailRecipientData->getRecipientSenderUID(),
            'sender_email_address' => $email->getSenderEmail(),
            'subject' => $email->getSubject(),
            'email_uid' => \Str::uuid(),
        ]);
   }
}
