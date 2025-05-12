<?php

use HalfShellStudios\FeedProcessor\Processors\XmlProcessor;
use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;
use HalfShellStudios\FeedProcessor\Exceptions\FileIsMalformedException;
use SimpleXMLElement;

test('XmlProcessor implements FeedProcessor', function (): void {
    $csvProcessor = new XmlProcessor('./tests/fixtures/sample.xml');
    expect($csvProcessor)->toBeInstanceOf(FeedProcessor::class);
});

test('XmlProcessor throws if file does not exist', function (): void {
    new XmlProcessor('some.xml');
})->throws(FileDoesNotExistException::class);

test('XmlProcessor throws exception on malformed data during process', function (): void {
    new XmlProcessor("./tests/fixtures/bad_sample.xml");
})->throws(FileIsMalformedException::class, 'File is malformed: String could not be parsed as XML');

test('XmlProcessor get() returns the processed object', function (): void {
    $csvProcessor = new XmlProcessor('./tests/fixtures/sample.xml');
    $dataObject = $csvProcessor->get();
    expect($dataObject)->toBeInstanceOf(SimpleXMLElement::class);
});

test('XmlProcessor toJson() returns JSON after processing', function (): void {
    $csvProcessor = new XmlProcessor('./tests/fixtures/sample.xml');
    $json = $csvProcessor->toJson();
    $data = json_decode($json, true);

    expect(json_last_error())
        ->toBe(JSON_ERROR_NONE)
        ->and($data)->toBeArray()
        ->and(count($data))->toBe(1836);
});

test('XmlProcessor toArray() returns array after processing', function (): void {
    $csvProcessor = new XmlProcessor('./tests/fixtures/sample.xml');
    $records = $csvProcessor->toArray();

    expect($records)
        ->toBeArray()
        ->and(count($records))
        ->toBe(1836);
});
