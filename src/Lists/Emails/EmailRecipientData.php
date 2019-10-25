<?php namespace SamJoyce777\Marketing\Lists\Emails;

use Global4Communications\Residential\Core\Models\ResidentialCustomer;
use Carbon\Carbon;
use SamJoyce777\Marketing\Lists\Emails\ListProviderInterface;

/**
 * Email reciepient data is the data that is passed to the email to create the email
 * Class EmailRecipientData
 * @package SamJoyce777\Marketing\Lists\Emails
 */
class EmailRecipientData
{
    protected $data = [];

    protected $allowed_keys;

    public function __construct()
    {
        $this->data['recipient_sender_uid'] = null;

        $this->allowed_keys = ['name', 'address', 'email', 'email_name', 'residential_customer_id'];
    }

    /**
     * Set the recipient sender uid
     * @param string $recipient_sender_uid
     */
    public function setRecipientSenderUID(string $recipient_sender_uid)
    {
        $this->data['recipient_sender_uid'] = $recipient_sender_uid;
    }

    /**
     * Get the recipient sender uid
     */
    public function getRecipientSenderUID():?string
    {
        return $this->data['recipient_sender_uid'];
    }

    /**
     * Sets the data that will be passed to the email blade template
     * @param array $data
     * @throws \Exception
     */
    public function setData(array $data)
    {
        if(!$this->allKeysValid($data)) throw new \Exception('You can only pass valid key names to the email template: '.$this->listAllowedKeys());

        $this->data = $data;
    }

    /**
     * @param bool $array
     * @return array|object
     */
    public function getData($array = true)
    {
        return ($array) ? (array)$this->data : (object)$this->data;
    }

    /**
     * Returns a fields
     * @return string
     */
    public function getField($field):string
    {
        return isset($this->data[$field]) ? $this->data[$field] : null;
    }

    /**
     * Check to see if the array has only valid key names
     * @param $data
     * @return bool
     */
    protected function allKeysValid($data):bool
    {
        foreach ($data as $key => $value){
            if(!in_array($key, $this->allowed_keys)) return false;
        }

        return true;
    }

    /**
     * Returns string of all allowed keys
     * @return string
     */
    protected function listAllowedKeys():string
    {
        $list = '';

        foreach ($this->allowed_keys as $key){
            $list .= $key .', ';
        }

        return $list;
    }
}
