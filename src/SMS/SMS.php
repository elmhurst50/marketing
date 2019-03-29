<?php namespace SamJoyce777\Marketing\SMS;

use SamJoyce777\Marketing\Lists\SMS\SMSRecipientData;
use SamJoyce777\Marketing\Managers\SMS\SMSManager;

abstract class SMS
{
    protected $title;

    protected $description;

    protected $message;

    protected $required_data;

    protected $sms_manager;

    public function __construct()
    {
        $this->sms_manager = new SMSManager();
    }

    /**
     * Sends the actual sms
     * @param $mobile_number
     * @param SMSRecipientData $smsRecipientData
     */
    public function send($mobile_number, SMSRecipientData $smsRecipientData)
    {
        $hasAllRequiredData = $this->hasAllRequiredData($smsRecipientData->getData());

        if ($hasAllRequiredData === true) {
            try {
                $this->message = $this->createMessage($smsRecipientData->getData());

                $this->sms_manager->send($mobile_number, $this->message);
            } catch (\Exception $e) {
                \Logger::error('sms', 'SMS.php - Could not send sms to: ' . $mobile_number . ' due to: ' . $e->getMessage());
            }
        } else {
            \Logger::error('sms', 'SMS.php - Not enough data fields: ' . $mobile_number . ' Missing: ' . serialize($hasAllRequiredData) . ' Provided: ' . serialize($smsRecipientData->getData()));
        }
    }

    /**
     * Cheacks to see if the required data fields for the blade are provided
     * @param array $data
     * @return array|bool
     */
    protected function hasAllRequiredData(array $data)
    {
        $missing_fields = [];

        foreach ($this->required_data as $field) {
            if (!array_key_exists($field, $data)) $missing_fields[] = $field;
        }

        if (count($missing_fields) > 0) return $missing_fields;

        return true;
    }

    /**
     * Returns the title of the sms
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns description of the sms
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns blade template of the sms
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Creates default/blank data to viewing tests
     * @return array
     */
    public function getDefaultData()
    {
        $data = [];

        foreach ($this->required_data as $field){
            $data[$field] = strtoupper($field);
        }

        return $data;
    }
}
