<?php namespace ElmhurstProjects\CommunicationsExampleReal\EmailCreators\Development;

use SamJoyce777\Marketing\EmailCreators\EmailCreatorAbstract;
use SamJoyce777\Marketing\EmailCreators\EmailCreatorInterface;

class ConfirmOrderEmailCreator extends EmailCreatorAbstract implements EmailCreatorInterface
{
    protected $title = 'Confirm Order';

    protected $description = 'Confirms the order to the customer';

    protected $template = 'example-real::test';

    protected $sender_email = 'orders@global4.co.uk';

    protected $sender_name = 'Test Person';

    protected $subject = 'Order confirmation';

    protected $required_view_data_fields = ['order_id', 'amount'];

    protected $tags = ['test tag'];
}
