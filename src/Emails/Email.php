<?php namespace SamJoyce777\Marketing\Emails;

use SamJoyce777\Marketing\Lists\Emails\EmailRecipientData;
use SamJoyce777\Marketing\Models\EmailSent;

/**
 * Is in charge of creating and sending an email
 * Class Email
 * @package SamJoyce777\Marketing\Emails
 */
abstract class Email
{
    protected $mandrill;

    protected $mandrill_array;

    protected $title;

    protected $description;

    protected $template;

    protected $sender_email;

    protected $sender_name;

    protected $subject;

    protected $required_data;

    protected $tags = [];

    protected $meta = [];

    public function __construct()
    {
        $this->mandrill = new \Mandrill(env('MANDRILL_KEY'));

        $this->mandrill_array = $this->setBlankMandrillArray();
    }

    /**
     * Sends the actual email
     * @param $email_address
     * @param EmailRecipientData $emailRecipientData
     * @param EmailSent $emailSent
     */
    public function send($email_address, EmailRecipientData $emailRecipientData, EmailSent $emailSent)
    {
        $hasAllRequiredData = $this->hasAllRequiredData($emailRecipientData->getData());

        if ($hasAllRequiredData === true) {
            try {
                $html = view($this->getTemplate())
                    ->with('data', $emailRecipientData->getData(false))
                    ->with('unique_token', $emailSent->unique_token)
                    ->render();

                $this->setEmail($html, '', $this->getSubject());

                $this->setTo([[
                    'email' => $email_address,
                    'name' => $emailRecipientData->getField('email_name'),
                    'type' => 'to'
                ]]);

                $this->setFrom($this->getSenderEmail(), $this->getSenderName());

                $this->setTags($this->getTags());

                $this->setMeta(['eid' => $emailSent->id]);

                $this->mandrill->messages->send($this->mandrill_array);
            } catch (\Exception $e) {
                \Logger::error('email', 'Email.php - Could not send email to: ' . $email_address . ' due to: ' . $e->getMessage() . ' Array: ' . serialize($this->mandrill_array));
            }
        } else {
            \Logger::error('email', 'Email.php - Not enough data fields: ' . $email_address . ' Missing: ' . serialize($hasAllRequiredData) . ' Provided: ' . serialize($emailRecipientData->getData()));
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

    /**
     * Returns the title of the email
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns description of the email
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns blade template of the email
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Returns sender's email of the email
     * @return mixed
     */
    public function getSenderEmail()
    {
        return $this->sender_email;
    }

    /**
     * Returns sender's name of the email
     * @return mixed
     */
    public function getSenderName()
    {
        return $this->sender_name;
    }

    /**
     * Returns subject of the email
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Returns tags of the email
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Returns meta of the email
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }
}
