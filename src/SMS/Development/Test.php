<?php namespace SamJoyce777\Marketing\SMS\Development;

use SamJoyce777\Marketing\SMS\SMS;
use SamJoyce777\Marketing\SMS\SMSInterface;

class Test extends SMS implements SMSInterface
{
    protected $title = 'Test SMS';

    protected $description = 'Test SMS for development work';

    protected $message = '';

    protected $required_data = ['name'];

    public function createMessage(array $data)
    {
        $this->message = 'This is a test SMS for '.$data['name'];

        return $this->message;
    }
}
