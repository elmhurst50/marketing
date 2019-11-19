<?php namespace SamJoyce777\Marketing\Lists\Emails\Development;

use SamJoyce777\Marketing\Emails\EmailRecipientData;
use SamJoyce777\Marketing\Lists\Emails\ListProviderAbstract;
use SamJoyce777\Marketing\Lists\Emails\ListProviderInterface;

class TestList extends ListProviderAbstract implements ListProviderInterface
{
    protected $title = 'Test email';

    protected $description = 'Just to developers';

    public function query(array $options)
    {
        return false;
    }

    /**
     * Returns list of all emails
     * @param array $options
     * @return array
     */
    public function getList(array $options):array
    {
        return [
            'sam.joyce@global4.co.uk',
            'samjoyce777@gmail.com'
        ];
    }

    /**
     * Returns count of all emails
     * @return int
     */
    public function getCount(array $options):int
    {
        return count($this->getList($options));
    }

    /**
     * Returns sql all emails
     * @return string
     */
    public function getSql(array $options):string
    {
        return 'No sql - coded in';
    }

    /**
     * gets the data to be used by email templates
     * @param string $email
     * @return EmailRecipientData
     */
    public function getEmailRecipientData(string $email):EmailRecipientData
    {
        if($email == 'samjoyce777@gmail.com'){
            $this->email_recipient_data->setData([
                'name' => 'Sam Joyce',
                'email' => 'samjoyce777@gmail.com',
                'email_name' => 'Sam Joyce',
                'residential_customer_id' => 777
            ]);
        }else{
            $this->email_recipient_data->setData([
                'name' => 'Sam Joyce',
                'email' => 'sam.joyce@global4.co.uk',
                'email_name' => 'Sam Joyce',
                'residential_customer_id' => 666
            ]);
        }


        return $this->email_recipient_data;
    }
}
