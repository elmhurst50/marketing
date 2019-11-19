<?php namespace ElmhurstProjects\CommunicationsExampleSimple\EmailCreators\Development;

use SamJoyce777\Marketing\EmailCreators\EmailCreatorAbstract;
use SamJoyce777\Marketing\EmailCreators\EmailCreatorInterface;

class TestEmailCreator extends EmailCreatorAbstract implements EmailCreatorInterface
{
    protected $title = 'Test Email';

    protected $description = 'Test Email for development work';

    protected $template = 'marketing.development.test';

    protected $sender_email = 'test@global4.co.uk';

    protected $sender_name = 'Test Person';

    protected $subject = 'Test Subject 3';

    protected $required_data = ['name', 'email', 'order_id'];

    protected $tags = ['test tag'];
}
