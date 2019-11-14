<?php namespace SamJoyce777\Marketing\EmailDispatchers;

use SamJoyce777\Marketing\EmailCreators\EmailCreatorInterface;
use SamJoyce777\Marketing\EmailCreators\EmailRecipientData;

/**
 * Is in charge of creating and sending an email
 * Class Email
 * @package SamJoyce777\Marketing\Emails
 */
interface EmailDispatcherInterface
{
    public function send(string $email_address, EmailRecipientData $emailRecipientData, EmailCreatorInterface $email);
}
