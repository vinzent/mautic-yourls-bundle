<?php

declare(strict_types=1);

namespace MauticPlugin\MauticYourlsBundle\Integration\Support;

use Mautic\IntegrationsBundle\Integration\DefaultConfigFormTrait;
use Mautic\IntegrationsBundle\Integration\Interfaces\ConfigFormAuthInterface;
use Mautic\IntegrationsBundle\Integration\Interfaces\ConfigFormInterface;
use MauticPlugin\MauticYourlsBundle\Form\Type\ConfigAuthType;
use MauticPlugin\MauticYourlsBundle\Integration\YourlsBundleIntegration;

class ConfigSupport extends YourlsBundleIntegration implements ConfigFormInterface, ConfigFormAuthInterface
{
    use DefaultConfigFormTrait;

    public function getAuthConfigFormName(): string
    {
        return ConfigAuthType::class;
    }
}
