<?php

declare(strict_types=1);

namespace MauticPlugin\MauticYourlsBundle\Integration;

use Mautic\IntegrationsBundle\Exception\IntegrationNotFoundException;
use Mautic\IntegrationsBundle\Helper\IntegrationsHelper;
use Mautic\PluginBundle\Entity\Integration;
use MauticPlugin\MauticYourlsBundle\Form\Type\ConfigAuthType;

class Config
{
    private \Mautic\IntegrationsBundle\Helper\IntegrationsHelper $integrationsHelper;

    public function __construct(IntegrationsHelper $integrationsHelper)
    {
        $this->integrationsHelper = $integrationsHelper;
    }

    public function isPublished(): bool
    {
        try {
            $integration = $this->getIntegrationEntity();

            return (bool) $integration->getIsPublished() ?: false;
        } catch (IntegrationNotFoundException $e) {
            return false;
        }
    }

    /**
     * @return mixed[]
     */
    public function getFeatureSettings(): array
    {
        try {
            $integration = $this->getIntegrationEntity();

            return $integration->getFeatureSettings() ?: [];
        } catch (IntegrationNotFoundException $e) {
            return [];
        }
    }

    /**
     * @throws IntegrationNotFoundException
     */
    public function getIntegrationEntity(): Integration
    {
        $integrationObject = $this->integrationsHelper->getIntegration(YourlsBundleIntegration::NAME);

        return $integrationObject->getIntegrationConfiguration();
    }

    public function isConfigured(): bool
    {
        $apiKeys = $this->getApiKeys();

        return !empty($apiKeys[ConfigAuthType::SECRET_SIGNATURE_TOKEN]);
    }

    public function getSecretSignatureToken(): string
    {
        return $this->getApiKeys()[ConfigAuthType::SECRET_SIGNATURE_TOKEN] ?? '';
    }

    public function getApiUrl(): string
    {
        return $this->getApiKeys()[ConfigAuthType::API_URL] ?? '';
    }

    /**
     * @return string[]
     */
    private function getApiKeys(): array
    {
        try {
            $integration = $this->getIntegrationEntity();

            return $integration->getApiKeys() ?: [];
        } catch (IntegrationNotFoundException $e) {
            return [];
        }
    }
}
