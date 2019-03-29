<?php namespace SamJoyce777\Marketing\Lists\Emails\Development;

use Global4Communications\Residential\Core\Models\ResidentialCustomer;
use SamJoyce777\Marketing\Lists\Emails\EmailRecipientData;
use SamJoyce777\Marketing\Lists\Emails\ListProvider;
use SamJoyce777\Marketing\Lists\Emails\ListProviderInterface;

class Test extends ListProvider implements ListProviderInterface
{
    protected $title = 'Test email';

    protected $description = 'Just to developers';

    protected $email_recipient_data;

    public function __construct()
    {
        $this->email_recipient_data = new EmailRecipientData();
    }

    public function query($options)
    {
        return false;
    }

    /**
     * Returns list of all emails
     * @return mixed
     */
    public function getList($options)
    {
        return [
            'sam.joyce@global4.co.uk',
            'samjoyce777@gmail.com'
        ];
    }

    /**
     * Returns count of all emails
     * @return mixed
     */
    public function getCount($options)
    {
        return count($this->getList($options));
    }

    /**
     * Returns sql all emails
     * @return mixed
     */
    public function getSql($options)
    {
        return 'No sql - coded in';
    }

    /**
     * gets the data to be used by email templates
     * @param $email
     * @return EmailRecipientData
     */
    public function getEmailRecipientData($email)
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
