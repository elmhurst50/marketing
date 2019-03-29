<?php namespace SamJoyce777\Marketing\Lists\SMS\Development;

use SamJoyce777\Marketing\Lists\SMS\SMSRecipientData;
use SamJoyce777\Marketing\Lists\SMS\ListProvider;
use SamJoyce777\Marketing\Lists\SMS\ListProviderInterface;

class Test extends ListProvider implements ListProviderInterface
{
    protected $title = 'Test SMS';

    protected $description = 'SMS just to developers';

    protected $sms_recipient_data;

    public function __construct()
    {
        $this->sms_recipient_data = new SMSRecipientData();
    }

    public function query($options)
    {
        return false;
    }

    /**
     * Returns list of all emails
     * @return mixed
     */
    public function getList($options)
    {
        return [
            '07713158316'
        ];
    }

    /**
     * Returns count of all emails
     * @return mixed
     */
    public function getCount($options)
    {
        return count($this->getList($options));
    }

    /**
     * Returns sql all emails
     * @return mixed
     */
    public function getSql($options)
    {
        return 'No sql - coded in';
    }

    /**
     * gets the data to be used by email templates
     * @param $mobile_number
     * @return SMSRecipientData
     */
    public function getSMSRecipientData($mobile_number)
    {
        $this->sms_recipient_data->setData([
            'name' => 'Sam Joyce',
            'residential_customer_id' => 777
        ]);

        return $this->sms_recipient_data;
    }
}
