<?php namespace SamJoyce777\Marketing\Lists\Emails;


interface ListProviderInterface
{
    public function getTitle();

    public function getDescription();

    /**
     * Returns list of all emails
     * @param array $options
     * @return array
     */
    public function getList(array $options): array;

    /**
     * Returns count of emails
     * @param array $options
     * @return integer
     */
    public function getCount(array $options): int;

    /**
     * Returns sql of query
     * @param array $options
     * @return string
     */
    public function getSql(array $options): string;

    /**
     * the query
     * @param array $options
     * @return mixed
     */
    public function query(array $options);

    /**
     * gets the data to be used by email templates
     * @param string $email
     * @return EmailRecipientData
     */
    public function getEmailRecipientData(string $email);
}