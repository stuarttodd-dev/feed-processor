<?php

namespace HalfShellStudios\FeedProcessor\Interface;

interface FeedProcessor
{
    public function get(): mixed;

    /** @return string[] */
    public function toArray(): array;

    public function toJson(): string;

    public function process(): void;
}
