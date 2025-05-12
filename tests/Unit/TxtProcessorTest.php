<?php

use HalfShellStudios\FeedProcessor\Processors\TxtProcessor;
use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;
use HalfShellStudios\FeedProcessor\Exceptions\FileIsMalformedException;
use League\Csv\Reader;

test('TxtProcessor implements FeedProcessor', function (): void {
    $csvProcessor = new TxtProcessor('./tests/fixtures/sample.txt');
    expect($csvProcessor)->toBeInstanceOf(FeedProcessor::class);
});

test('TxtProcessor throws if file does not exist', function (): void {
    new TxtProcessor('some.txt');
})->throws(FileDoesNotExistException::class);

test('TxtProcessor throws exception on malformed data during process (empty file)', function (): void {
    new TxtProcessor("./tests/fixtures/bad_sample1.txt");
})->throws(FileIsMalformedException::class, 'File is malformed: The header record does not exist or is empty');

test('TxtProcessor throws exception on malformed data during process (invalid file)', function (): void {
    new TxtProcessor("./tests/fixtures/bad_sample2.txt");
})->throws(FileIsMalformedException::class, 'File is malformed: The header record contains duplicate column names.');

test('TxtProcessor get() returns the processed object', function (): void {
    $csvProcessor = new TxtProcessor('./tests/fixtures/sample.txt');
    $dataObject = $csvProcessor->get();
    expect($dataObject)->toBeInstanceOf(Reader::class);
});

test('TxtProcessor toJson() returns JSON after processing', function (): void {
    $csvProcessor = new TxtProcessor('./tests/fixtures/sample.txt');
    $json = $csvProcessor->toJson();
    $data = json_decode($json, true);

    expect(json_last_error())
        ->toBe(JSON_ERROR_NONE)
        ->and($data)->toBeArray()
        ->and(count($data))->toBe(2175);
});

test('TxtProcessor toArray() returns array after processing', function (): void {
    $csvProcessor = new TxtProcessor('./tests/fixtures/sample.txt');
    $records = $csvProcessor->toArray();

    expect($records)
        ->toBeArray()
        ->and(count($records))
        ->toBe(2175);
});
