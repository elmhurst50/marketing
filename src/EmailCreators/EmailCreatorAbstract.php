<?php namespace SamJoyce777\Marketing\EmailCreators;

use SamJoyce777\Marketing\EmailViewData\EmailViewDataInterface;

/**
 * Is in charge of creating an email
 * Class Email
 * @package SamJoyce777\Marketing\Emails
 */
abstract class EmailCreatorAbstract
{
    protected $title;

    protected $description;

    protected $template;

    protected $sender_email;

    protected $sender_name;

    protected $subject;

    protected $view_data_fields = [];

    protected $required_view_data_fields = ['name'];

    protected $tags = [];

    protected $meta = [];

    /**
     * Gets the HTML for the email
     * @return string
     */
    public function getHTML(): string
    {
        return view($this->getTemplate())
            ->with('data', (object)$this->view_data_fields)
            ->render();
    }

    /**
     * Checks to see if the required data fields for the blade are provided
     * @return bool
     */
    public function hasAllRequiredData(): bool
    {
        return count($this->getMissingFields()) == 0;
    }

    /**
     * Get the missing fields from the supplied view data fields
     * @return array
     */
    public function getMissingFields(): array
    {
        $missing_fields = [];

        foreach ($this->required_view_data_fields as $field) {
            if (!array_key_exists($field, $this->view_data_fields)) $missing_fields[] = $field;
        }

        return $missing_fields;
    }

    /**
     * Get the required view data fields for this email
     * @return array
     */
    public function getRequiredFields(): array
    {
        return $this->required_view_data_fields;
    }

    /**
     * Sets the view data fields for blade template
     * @param EmailViewDataInterface $emailViewData
     */
    public function setViewDataFields(EmailViewDataInterface $emailViewData)
    {
        $this->view_data_fields = $emailViewData->getViewData();
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
