<?php namespace SamJoyce777\Marketing\SMS;


use SamJoyce777\Marketing\Lists\SMS\SMSRecipientData;

interface SMSInterface
{
    public function getTitle();

    public function getDescription();

    public function getMessage();

    public function send($mobile_number, SMSRecipientData $data);

    public function createMessage(array $data);

    public function getDefaultData();
}