<?php

use HalfShellStudios\FeedProcessor\FeedProcessorFactory;
use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use HalfShellStudios\FeedProcessor\Processors\CsvProcessor;
use HalfShellStudios\FeedProcessor\Processors\TxtProcessor;
use HalfShellStudios\FeedProcessor\Processors\XmlProcessor;
use HalfShellStudios\FeedProcessor\Processors\RssProcessor;
use HalfShellStudios\FeedProcessor\Processors\JsonProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;

test('throws exception when file does not exist', function (): void {
    FeedProcessorFactory::make("nonexistent/path/file.csv");
})->throws(FileDoesNotExistException::class);

test('throws exception when file has an invalid extension', function (): void {
    FeedProcessorFactory::make("./tests/fixtures/sample.png");
})->throws(InvalidArgumentException::class, 'Unsupported file type: png');

test('returns csv processor class correctly', function (): void {
    $class = FeedProcessorFactory::make("./tests/fixtures/sample.csv");
    expect($class)->toBeInstanceOf(FeedProcessor::class);
    expect($class)->toBeInstanceOf(CsvProcessor::class);
});

test('returns txt processor class correctly', function (): void {
    $class = FeedProcessorFactory::make("./tests/fixtures/sample.txt");
    expect($class)->toBeInstanceOf(FeedProcessor::class);
    expect($class)->toBeInstanceOf(TxtProcessor::class);
});

test('returns xml processor class correctly', function (): void {
    $class = FeedProcessorFactory::make("./tests/fixtures/sample.xml");
    expect($class)->toBeInstanceOf(FeedProcessor::class);
    expect($class)->toBeInstanceOf(XmlProcessor::class);
});

test('returns rss processor class correctly', function (): void {
    $class = FeedProcessorFactory::make("./tests/fixtures/sample.rss");
    expect($class)->toBeInstanceOf(FeedProcessor::class);
    expect($class)->toBeInstanceOf(RssProcessor::class);
});

test('returns json processor class correctly', function (): void {
    $class = FeedProcessorFactory::make("./tests/fixtures/sample.json");
    expect($class)->toBeInstanceOf(FeedProcessor::class);
    expect($class)->toBeInstanceOf(JsonProcessor::class);
});
