<?php namespace SamJoyce777\Marketing\Lists\Emails;


interface ListProviderInterface
{
    public function getTitle();

    public function getDescription();

    /**
     * Returns list of all emails
     * * @param $options - object
     * @return mixed
     */
    public function getList($options);

    /**
     * Returns count of emails
     * * @param $options - object
     * @return mixed
     */
    public function getCount($options);

    /**
     * Returns sql of query
     * * @param $options - object
     * @return mixed
     */
    public function getSql($options);

    /**
     * the query
     * * @param $options - object
     * @return mixed
     */
    public function query($options);

    /**
     * gets the data to be used by email templates
     * @param $email
     * @return EmailRecipientData
     */
    public function getEmailRecipientData($email);
}