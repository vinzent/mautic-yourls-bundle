<?php

declare(strict_types=1);

namespace MauticPlugin\MauticYourlsBundle\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MauticPlugin\MauticYourlsBundle\Integration\Config;

class Connection
{
    private Client $client;

    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getClient(): Client
    {
        if (!isset($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @throws GuzzleException
     */
    public function sendRequest(array $form_params): \Psr\Http\Message\ResponseInterface
    {
        $timestamp = time();
        $signature = hash('sha512', $timestamp . $this->config->getSecretSignatureToken());

        $base_form_params = [
              'format' => 'json',
              'hash' => 'sha512',
              'timestamp' => $timestamp,
              'signature' => $signature,
        ];

        $response = $this->getClient()->post(
          $this->config->getApiUrl(),
            [
                'form_params' => array_merge($base_form_params, $form_params),
            ]
        );
          
        return $response;
    }

    public function getShortUrl(string $url): string
    {
        $response = $this->sendRequest(['action' => 'shorturl', 'url' => $url]);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response['shorturl'] ?? '';
    }

    public function getVersion(): string
    {
        $response = $this->sendRequest(['action' => 'version']);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response['version'] ?? '';
    }

    public function isValidConnection(): bool
    {
        try {
            $version = $this->getVersion();
            if (!empty($version)) {
                return true;
            }
            return false;
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }

    public function isEnabled(): bool
    {
        return $this->config->isPublished() && $this->config->isConfigured();
    }
}
