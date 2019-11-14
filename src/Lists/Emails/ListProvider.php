<?php namespace SamJoyce777\Marketing\Lists\Emails;

use SamJoyce777\Marketing\Emails\EmailRecipientData;

abstract class ListProvider
{
    protected $title;

    protected $description;

    protected $email_recipient_data;

    public function __construct()
    {
        $this->email_recipient_data = new EmailRecipientData();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getList($options)
    {
        $query = $this->query($options);

        return $query->toArray();
    }

    /**
     * Returns the qty in the list
     * @param $options
     * @return int
     */
    public function getCount($options):int
    {
        $query = $this->query($options);

        return $query->count();
    }

    /**
     * Returns the SQL string
     * @param $options
     * @return string
     */
    public function getSql($options):string
    {
        $query = $this->query($options);

        return $query->toSql();
    }
}
