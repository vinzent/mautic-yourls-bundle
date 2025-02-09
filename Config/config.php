<?php

return [
    'name'        => 'MauticYourlsBundle',
    'description' => 'Yourls bundle for Mautic.',
    'version'     => '1.0',
    'author'      => 'Vinzent',
    'services'    => [
        'others' => [
            'mautic.shortener.yourls' => [
                'class'     => \MauticPlugin\MauticYourlsBundle\Shortener\YourlsService::class,
                'arguments' => [
                    'mautic.yourls.connection',
                    'monolog.logger.mautic',
                ],
                'tags'      => [
                    'mautic.shortener.service',
                ],
            ],
            'mautic.yourls.config'            => [
                'class'     => \MauticPlugin\MauticYourlsBundle\Integration\Config::class,
                'arguments' => [
                    'mautic.integrations.helper',
                ],
            ],
            'mautic.yourls.connection'            => [
                'class'     => \MauticPlugin\MauticYourlsBundle\Client\Connection::class,
                'arguments' => [
                    'mautic.yourls.config',
                ],
            ],
        ],
        'integrations' => [
            // Basic definitions with name, display name and icon
            'mautic.integration.yourlsbundle' => [
                'class' => \MauticPlugin\MauticYourlsBundle\Integration\YourlsBundleIntegration::class,
                'tags'  => [
                    'mautic.integration',
                    'mautic.basic_integration',
                ],
            ],
            // Provides the form types to use for the configuration UI
            'yourlsbundle.integration.configuration' => [
                'class'     => \MauticPlugin\MauticYourlsBundle\Integration\Support\ConfigSupport::class,
                'tags'      => [
                    'mautic.config_integration',
                ],
            ],
        ],
        'validators' => [
            'yourlsbundle.validator.connection_validator' => [
                'class'     => \MauticPlugin\MauticYourlsBundle\Validator\Constraints\ConnectionValidator::class,
                'arguments' => [
                    'mautic.yourls.connection',
                    'translator',
                ],
                'tags' => [
                    'name' => 'validator.constraint_validator',
                ],
            ],
        ],
    ],
];
