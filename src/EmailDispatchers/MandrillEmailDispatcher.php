<?php namespace SamJoyce777\Marketing\EmailDispatchers;

use SamJoyce777\Marketing\Emails\EmailInterface;
use SamJoyce777\Marketing\Lists\Emails\EmailRecipientData;

/**
 * Is in charge of creating and sending an email
 * Class Email
 * @package SamJoyce777\Marketing\Emails
 */
class MandrillEmailDispatcher extends EmailDispatcherAbstract
{
    protected $mandrill;

    protected $mandrill_array;

    public function __construct()
    {
        $this->mandrill = new \Mandrill(env('MANDRILL_KEY'));

        $this->mandrill_array = $this->setBlankMandrillArray();
    }

    /**
     * Sends the actual email
     * @param $email_address
     * @param EmailRecipientData $emailRecipientData - Data sent about the email from the email list provider
     * @param EmailInterface $email - Email class to send
     */
    public function send(string $email_address, EmailRecipientData $emailRecipientData, EmailInterface $email)
    {
        $html = $email->getHTML($emailRecipientData);

        if ($html) {
            $emailSent = $this->recordEmailInDatabase($email_address,  $emailRecipientData,  $email);

            $this->setEmail($html, '', $email->getSubject());

            $this->setTo([[
                'email' => $email_address,
                'name' => $emailRecipientData->getField('email_name'),
                'type' => 'to'
            ]]);

            $this->setFrom($email->getSenderEmail(), $email->getSenderName());

            $this->setTags($email->getTags());

            $this->setMeta(['eid' => $emailSent->email_uid]);

            $this->mandrill->messages->send($this->mandrill_array);

        } else {
            \Logger::error('email', 'Email.php - Not enough data fields: ' . $email_address . ' Missing: ' . serialize($html) . ' Provided: ' . serialize($emailRecipientData->getData()));
        }
    }

    /**
     * Set the email array for mandrill array
     * @return array
     */
    protected function setBlankMandrillArray()
    {
        return array(
            'html' => '',
            'text' => '',
            'subject' => '',
            'from_email' => '',
            'from_name' => '',
            'to' => [[]],
            'headers' => [],
            'important' => false,
            'track_opens' => true,
            'track_clicks' => true,
            'auto_text' => null,
            'auto_html' => null,
            'inline_css' => null,
            'url_strip_qs' => null,
            'preserve_recipients' => null,
            'view_content_link' => null,
            'bcc_address' => null,
            'tracking_domain' => null,
            'signing_domain' => null,
            'return_path_domain' => null,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => [[]],
            'merge_vars' => [[]],
            'tags' => [],
            'metadata' => [],
            'recipient_metadata' => array(
                array(
                    'rcpt' => ''//$email
                )
            ),
        );
    }

    /**
     * Set Meta
     * @param array $meta
     */
    protected function setMeta(array $meta)
    {
        $this->mandrill_array['metadata'] = $meta;
    }

    /**
     * Set Tags
     * @param array $tags
     */
    protected function setTags(array $tags)
    {
        $this->mandrill_array['tags'] = $tags;
    }

    /**
     * Set the headers
     * @param array $headers
     */
    protected function setHeaders(array $headers)
    {
        $this->mandrill_array['headers'] = $headers;
    }

    /**
     * Set the email data
     * @param $html
     * @param $text
     * @param $subject
     */
    protected function setEmail($html, $text, $subject)
    {
        $this->mandrill_array['html'] = $html;
        $this->mandrill_array['text'] = $text;
        $this->mandrill_array['subject'] = $subject;
    }

    /**
     * Set to data
     * @param array $to - array of associated arrays
     */
    protected function setTo(array $to)
    {
        $this->mandrill_array['to'] = $to;
    }

    /**
     * Set from data
     * @param $email_address
     * @param $email_name
     */
    protected function setFrom($email_address, $email_name)
    {
        $this->mandrill_array['from_email'] = $email_address;
        $this->mandrill_array['from_name'] = $email_name;
    }
}
