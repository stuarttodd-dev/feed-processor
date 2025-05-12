<?php

namespace HalfShellStudios\FeedProcessor\Abstractions;

use HalfShellStudios\FeedProcessor\Exceptions\FileDoesNotExistException;

abstract class BaseProcessor
{
    protected mixed $dataObject = null;

    /** @phpstan-ignore-next-line  */
    protected array $recordsArray = [];

    protected string $recordsJson = '';

    /**
     * @throws FileDoesNotExistException
     */
    public function __construct(protected string $filePath)
    {
        if (!file_exists($this->filePath)) {
            throw new FileDoesNotExistException($this->filePath);
        }

        $this->process();
    }

    abstract public function process(): void;

    public function get(): mixed
    {
        return $this->dataObject;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return $this->recordsArray;
    }

    public function toJson(): string
    {
        return $this->recordsJson;
    }
}
