<?php namespace SamJoyce777\Marketing\Emails\Development;

use SamJoyce777\Marketing\Emails\EmailAbstract;
use SamJoyce777\Marketing\Emails\EmailInterface;

class Test extends EmailAbstract implements EmailInterface
{
    protected $title = 'Test Email';

    protected $description = 'Test Email for development work';

    protected $template = 'marketing.development.test';

    protected $sender_email = 'test@global4.co.uk';

    protected $sender_name = 'Test Person';

    protected $subject = 'Test Subject 3';

    protected $required_data = ['name', 'email'];

    protected $tags = ['test tag'];
}
