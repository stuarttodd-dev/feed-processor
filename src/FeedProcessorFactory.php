<?php

namespace HalfShellStudios\FeedProcessor;

use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use HalfShellStudios\FeedProcessor\Processors\CsvProcessor;
use HalfShellStudios\FeedProcessor\Processors\JsonProcessor;
use HalfShellStudios\FeedProcessor\Processors\RssProcessor;
use HalfShellStudios\FeedProcessor\Processors\TxtProcessor;
use HalfShellStudios\FeedProcessor\Processors\XmlProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;
use InvalidArgumentException;

class FeedProcessorFactory
{
    /**
     * @throws FileDoesNotExistException
     */
    public static function make(string $filePath): FeedProcessor
    {
        if (!file_exists($filePath)) {
            throw new FileDoesNotExistException($filePath);
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($extension) {
            'csv'  => new CsvProcessor($filePath),
            'rss'  => new RssProcessor($filePath),
            'txt'  => new TxtProcessor($filePath),
            'xml'  => new XmlProcessor($filePath),
            'json' => new JsonProcessor($filePath),
            default => throw new InvalidArgumentException('Unsupported file type: ' . $extension),
        };
    }
}
