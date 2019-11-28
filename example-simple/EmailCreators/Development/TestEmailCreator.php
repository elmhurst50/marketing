<?php namespace ElmhurstProjects\CommunicationsExampleSimple\EmailCreators\Development;

use SamJoyce777\Marketing\EmailCreators\EmailCreatorAbstract;
use SamJoyce777\Marketing\EmailCreators\EmailCreatorInterface;

class TestEmailCreator extends EmailCreatorAbstract implements EmailCreatorInterface
{
    protected $title = 'Test Simple Email';

    protected $description = 'Test Email for development work';

    protected $template = 'example-simple::test';

    protected $sender_email = 'test@global4.co.uk';

    protected $sender_name = 'Test Person';

    protected $subject = 'Simple Example Test';

    protected $required_view_data_fields = ['name', 'email', 'order_id'];

    protected $tags = ['simple test'];
}
