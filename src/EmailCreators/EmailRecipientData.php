<?php namespace SamJoyce777\Marketing\EmailCreators;

use Global4Communications\Residential\Core\Models\ResidentialCustomer;
use Carbon\Carbon;
use SamJoyce777\Marketing\Emails\ListProviderInterface;

/**
 * Email recipient data is the data that is passed to the email to create the email
 * Class EmailRecipientData
 * @package SamJoyce777\Marketing\Emails
 */
class EmailRecipientData
{
    protected $recipient_sender_uid = null;

    protected $email_address = null;

    protected $email_name = null;

    /**
     * Set the recipient sender uid
     * @param string $recipient_sender_uid
     * @return $this
     */
    public function setRecipientSenderUID(string $recipient_sender_uid)
    {
        $this->recipient_sender_uid = $recipient_sender_uid;

        return $this;
    }

    /**
     * Get the recipient sender uid
     */
    public function getRecipientSenderUID():?string
    {
        return $this->recipient_sender_uid;
    }

    /**
     * Set the email address
     * @param string $email_address
     * @return $this
     */
    public function setEmailAddress(string $email_address)
    {
        $this->email_address = $email_address;

        return $this;
    }

    /**
     * Get the email receipt
     */
    public function getEmailAddress():?string
    {
        return $this->email_address;
    }

    /**
     * Set the email name
     * @param string $email_name
     * @return $this
     */
    public function setEmailName(string $email_name)
    {
        $this->email_name = $email_name;

        return $this;
    }

    /**
     * Get the email name
     */
    public function getEmailName():?string
    {
        return $this->email_name;
    }
}
