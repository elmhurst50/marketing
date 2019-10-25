<?php namespace SamJoyce777\Marketing\Emails;

use SamJoyce777\Marketing\Lists\Emails\EmailRecipientData;

/**
 * Is in charge of creating an email
 * Class Email
 * @package SamJoyce777\Marketing\Emails
 */
abstract class EmailAbstract
{
    protected $title;

    protected $description;

    protected $template;

    protected $sender_email;

    protected $sender_name;

    protected $subject;

    protected $required_data;

    protected $tags = [];

    protected $meta = [];

    /**
     * Gets the HTML for the email
     * @param EmailRecipientData $emailRecipientData
     * @return mixed
     */
    public function getHTML(EmailRecipientData $emailRecipientData):?string
    {
        $hasAllRequiredData = $this->hasAllRequiredData($emailRecipientData->getData());

        if ($hasAllRequiredData === true) {
            return view($this->getTemplate())
                ->with('data', $emailRecipientData->getData(false))
                ->render();
        } else {
            \Logger::error('email', 'Email.php - Not enough data fields: ' . serialize($emailRecipientData) . ' Missing: ' . serialize($hasAllRequiredData) . ' Provided: ' . serialize($emailRecipientData->getData()));

            return null;
        }
    }

    /**
     * Checks to see if the required data fields for the blade are provided
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
     * Returns the title of the email
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns description of the email
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns blade template of the email
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Returns sender's email of the email
     * @return string
     */
    public function getSenderEmail(): string
    {
        return $this->sender_email;
    }

    /**
     * Returns sender's name of the email
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->sender_name;
    }

    /**
     * Returns subject of the email
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Returns tags of the email
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Returns meta of the email
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }
}
