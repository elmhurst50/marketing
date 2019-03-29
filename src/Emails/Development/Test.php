<?php namespace SamJoyce777\Marketing\Emails\Development;

use Global4Communications\Residential\Core\Models\ResidentialCustomer;
use SamJoyce777\Marketing\Emails\Email;
use SamJoyce777\Marketing\Emails\EmailInterface;
use SamJoyce777\Marketing\Lists\Emails\ListProviderInterface;

class Test extends Email implements EmailInterface
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
