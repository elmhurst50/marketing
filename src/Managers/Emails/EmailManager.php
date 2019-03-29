<?php namespace SamJoyce777\Marketing\Managers\Emails;

use Carbon\Carbon;
use SamJoyce777\Marketing\Jobs\SendEmail;
use SamJoyce777\Marketing\Models\EmailBlackList;
use SamJoyce777\Marketing\Models\EmailSent;

class EmailManager
{
    /**
     * Adds the email to the work queue
     * @param $email_identifier
     * @param $list_class
     * @param $email_address
     * @param $delay_minutes
     * @return bool
     */
    public function queueEmail($email_identifier, $list_class, $email_address, $delay_minutes)
    {
        if(!$this->allowedToSend($email_address)) return false;

        $email_class = config('marketing.emails.' . $email_identifier);

        $list_provider = new $list_class;

        $emailRecipientData = $list_provider->getEmailRecipientData($email_address);

        $emailSent = EmailSent::create([
            'email' => $email_address,
            'unique_token' => createUniqueToken(),
            'email_identifier' => $email_identifier,
            'email_class' => $email_class,
            'queued_at' => Carbon::now()->toDateTimeString(),
            'residential_customer_id' => $emailRecipientData->getField('residential_customer_id')
        ]);

        SendEmail::dispatch($email_class, $list_class, $email_address, $emailSent->id)
            ->onQueue('emails')
            ->delay(now()->addMinutes($delay_minutes));

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