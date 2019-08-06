<?php namespace SamJoyce777\Marketing\Managers\SMS;

use \Global4Communications\SMSManager\Providers\TextAnywhere;
use SamJoyce777\Marketing\Models\SMS\SMSBlackList;

class SMSManager
{
    protected $sms_manager;

    public function __construct()
    {
        $this->sms_manager = new \Global4Communications\SMSManager\SMSManager(new TextAnywhere());
    }

    public function setCredentials()
    {
        $this->sms_manager->setCredentials(env('TEXTANYWHERE_USERNAME'), env('TEXTANYWHERE_PASSWORD'));

        return $this;
    }

    /**
     * Main entry to class to send the SMS via text service
     * @param $mobileNumber
     * @param $content
     * @return bool
     */
    public function send($mobileNumber, $content)
    {
        if (substr($mobileNumber, 0, 1) == '0') $mobileNumber = substr($mobileNumber, 1);

        if (strlen($mobileNumber) < 7 || strlen($mobileNumber) > 10) return false;

        $to = '+44' . $mobileNumber;

        if (\App::environment() == 'production') {
            try {
                $this->sms_manager->sendSMS($content, $to, [
                    'returnCSVString' => true,
                    'originator' => '',
                    'clientBillingReference' => 'SMS',
                    'clientMessageReference' => 'Standard Message',
                    'replyMethodID' => 5,
                    'replyData' => url('/sms/sms-reply')
                ]);
            } catch (\Exception $e) {
                return \Logger::error('SMS', 'Send SMS failed. ' . $e->getMessage(), [], $e->getLine(), $e->getMessage());
            }
            return true;
        } else {
            \Logger::debug('SMS', 'Local SMS sent to ' . $mobileNumber);
        }
    }

    /**
     * Adds mobile number to the black list
     * @param $mobile_number
     * @param string $reason
     * @return mixed
     */
    public function addToBlackList($mobile_number, $reason = '')
    {
        return SMSBlackList::create([
            'mobile_number' => $mobile_number,
            'reason' => $reason
        ]);
    }
}