<?php namespace SamJoyce777\Marketing\Emails;


use SamJoyce777\Marketing\Lists\Emails\EmailRecipientData;
use SamJoyce777\Marketing\Models\EmailSent;

interface EmailInterface
{
    public function getTitle();

    public function getDescription();

    public function getTemplate();

    public function getSenderEmail();

    public function getSenderName();

    public function getSubject();

    public function send($email_address, EmailRecipientData $data, EmailSent $emailSent);
}