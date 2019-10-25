<?php

return [
    'development' => [
        'test' => \SamJoyce777\Marketing\Emails\Development\Test::class,
        'outlook' => \SamJoyce777\Marketing\Emails\Development\Outlook::class,
    ],
    'another_category' => [
        'another_email' =>  \SamJoyce777\Marketing\Emails\Development\Outlook::class,
    ]
];