<?php

use HalfShellStudios\FeedProcessor\Processors\CsvProcessor;
use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;
use HalfShellStudios\FeedProcessor\Exceptions\FileIsMalformedException;
use League\Csv\Reader;

test('CsvProcessor implements FeedProcessor', function (): void {
    $csvProcessor = new CsvProcessor('./tests/fixtures/sample.csv');
    expect($csvProcessor)->toBeInstanceOf(FeedProcessor::class);
});

test('CsvProcessor throws if file does not exist', function (): void {
    new CsvProcessor('some.csv');
})->throws(FileDoesNotExistException::class);

test('CsvProcessor throws exception on malformed data during process', function (): void {
    new CsvProcessor("./tests/fixtures/bad_sample.csv");
})->throws(FileIsMalformedException::class, 'File is malformed: The header record contains duplicate column names.');

test('CsvProcessor get() returns the processed object', function (): void {
    $csvProcessor = new CsvProcessor('./tests/fixtures/sample.csv');
    $dataObject = $csvProcessor->get();
    expect($dataObject)->toBeInstanceOf(Reader::class);
});

test('CsvProcessor toJson() returns JSON after processing', function (): void {
    $csvProcessor = new CsvProcessor('./tests/fixtures/sample.csv');
    $json = $csvProcessor->toJson();
    $data = json_decode($json, true);

    expect(json_last_error())
        ->toBe(JSON_ERROR_NONE)
        ->and($data)->toBeArray()
        ->and(count($data))->toBe(3);
});

test('CsvProcessor toArray() returns array after processing', function (): void {
    $csvProcessor = new CsvProcessor('./tests/fixtures/sample.csv');
    $records = $csvProcessor->toArray();

    expect($records)
        ->toBeArray()
        ->and(count($records))
        ->toBe(3);
});
