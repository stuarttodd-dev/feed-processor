<?php

use HalfShellStudios\FeedProcessor\Processors\JsonProcessor;
use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;
use HalfShellStudios\FeedProcessor\Exceptions\FileIsMalformedException;

test('JsonProcessor implements FeedProcessor', function (): void {
    $csvProcessor = new JsonProcessor('./tests/fixtures/sample.json');
    expect($csvProcessor)->toBeInstanceOf(FeedProcessor::class);
});

test('JsonProcessor throws if file does not exist', function (): void {
    new JsonProcessor('some.json');
})->throws(FileDoesNotExistException::class);

test('JsonProcessor throws exception on malformed data during process', function (): void {
    new JsonProcessor("./tests/fixtures/bad_sample.json");
})->throws(FileIsMalformedException::class, 'File is malformed: unable to parse');

test('JsonProcessor get() returns the processed object', function (): void {
    $csvProcessor = new JsonProcessor('./tests/fixtures/sample.json');
    $dataObject = $csvProcessor->get();

    expect($dataObject)->toBeInstanceOf(StdClass::class);
});

test('JsonProcessor toJson() returns JSON after processing', function (): void {
    $csvProcessor = new JsonProcessor('./tests/fixtures/sample.json');
    $json = $csvProcessor->toJson();

    $data = json_decode($json, true);
    $products = $data['products'];

    expect(json_last_error())
        ->toBe(JSON_ERROR_NONE)
        ->and($products)->toBeArray()
        ->and(count($products))->toBe(30);
});

test('JsonProcessor toArray() returns array after processing', function (): void {
    $csvProcessor = new JsonProcessor('./tests/fixtures/sample.json');
    $records = $csvProcessor->toArray();
    $products = $records['products'];

    expect($records)
        ->toBeArray()
        ->and(count($products))
        ->toBe(30);
});
