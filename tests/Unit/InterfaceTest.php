<?php

use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;

beforeEach(function (): void {
    $this->interface = new ReflectionClass(FeedProcessor::class);
});

test('FeedProcessor interface has toArray method signature', function (): void {
    expect($this->interface->hasMethod('toArray'))->toBeTrue();
});

test('FeedProcessor interface has toJson method signature', function (): void {
    expect($this->interface->hasMethod('toJson'))->toBeTrue();
});

test('FeedProcessor interface has process method signature', function (): void {
    expect($this->interface->hasMethod('process'))->toBeTrue();
});

test('FeedProcessor interface has get method signature', function (): void {
    expect($this->interface->hasMethod('get'))->toBeTrue();
});
