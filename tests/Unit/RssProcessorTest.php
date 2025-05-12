<?php

use HalfShellStudios\FeedProcessor\Processors\RssProcessor;
use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;
use HalfShellStudios\FeedProcessor\Exceptions\FileIsMalformedException;

test('RssProcessor implements FeedProcessor', function (): void {
    $csvProcessor = new RssProcessor('./tests/fixtures/sample.rss');
    expect($csvProcessor)->toBeInstanceOf(FeedProcessor::class);
});

test('RssProcessor throws if file does not exist', function (): void {
    new RssProcessor('some.rss');
})->throws(FileDoesNotExistException::class);

test('RssProcessor throws exception on malformed data during process', function (): void {
    new RssProcessor("./tests/fixtures/bad_sample.rss");
})->throws(FileIsMalformedException::class, 'File is malformed: String could not be parsed as XML');

test('RssProcessor get() returns the processed object', function (): void {
    $csvProcessor = new RssProcessor('./tests/fixtures/sample.rss');
    $dataObject = $csvProcessor->get();
    expect($dataObject)->toBeInstanceOf(SimpleXMLElement::class);
});

test('RssProcessor toJson() returns JSON after processing', function (): void {
    $csvProcessor = new RssProcessor('./tests/fixtures/sample.rss');
    $json = $csvProcessor->toJson();
    $data = json_decode($json, true);

    expect(json_last_error())
        ->toBe(JSON_ERROR_NONE)
        ->and($data)->toBeArray()
        ->and(count($data))->toBe(7094);
});

test('RssProcessor toArray() returns array after processing', function (): void {
    $csvProcessor = new RssProcessor('./tests/fixtures/sample.rss');
    $records = $csvProcessor->toArray();

    expect($records)
        ->toBeArray()
        ->and(count($records))
        ->toBe(7094);
});
