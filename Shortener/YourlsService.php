<?php

declare(strict_types=1);

namespace MauticPlugin\MauticYourlsBundle\Shortener;

use GuzzleHttp\Exception\GuzzleException;
use Mautic\CoreBundle\Shortener\ShortenerServiceInterface;
use MauticPlugin\MauticYourlsBundle\Client\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class YourlsService implements ShortenerServiceInterface
{
    private Connection $connection;

    private LoggerInterface $logger;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->logger     = $logger;
        $this->connection = $connection;
    }

    public function shortenUrl(string $url): string
    {
        if (false === $this->isEnabled()) {
            return $url;
        }

        try {
            return $this->connection->getShortUrl($url);
        } catch (GuzzleException|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            return $url;
        }
    }

    public function isEnabled(): bool
    {
        return $this->connection->isEnabled();
    }

    public function getPublicName(): string
    {
        return 'Yourls';
    }
}
