<?php

declare(strict_types=1);

namespace MauticPlugin\MauticYourlsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Connection extends Constraint
{
    public string $message = 'mautic.yourls.connection.invalid';
}
