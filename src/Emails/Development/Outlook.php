<?php namespace SamJoyce777\Marketing\Emails\Development;

use SamJoyce777\Marketing\Emails\Email;
use SamJoyce777\Marketing\Emails\EmailInterface;

class Outlook extends Email implements EmailInterface
{
    protected $title = 'Outlook Test Email';

    protected $description = 'Test Outlook Email for development work';

    protected $template = 'marketing.development.outlook';

    protected $sender_email = 'test@global4.co.uk';

    protected $sender_name = 'Test Outlook Person';

    protected $subject = 'Test Subject Outlook';

    protected $required_data = ['name', 'email'];

    protected $tags = ['outlook tag'];
}
