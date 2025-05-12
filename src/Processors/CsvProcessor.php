<?php

namespace HalfShellStudios\FeedProcessor\Processors;

use HalfShellStudios\FeedProcessor\Abstractions\BaseProcessor;
use HalfShellStudios\FeedProcessor\Exceptions\FileIsMalformedException;
use HalfShellStudios\FeedProcessor\Interface\FeedProcessor;
use League\Csv\Reader;
use Exception;

class CsvProcessor extends BaseProcessor implements FeedProcessor
{
    /**
     * @throws FileIsMalformedException
     * @SuppressWarnings("StaticAccess")
     */
    #[\Override]
    public function process(): void
    {
        try {
            $this->dataObject = Reader::createFromPath($this->filePath, 'r');
            $this->dataObject->setHeaderOffset(0);
            $this->recordsArray = iterator_to_array($this->dataObject->getRecords());
            $this->recordsJson = (string)json_encode($this->recordsArray);
        } catch (Exception $exception) {
            throw new FileIsMalformedException(
                $exception->getMessage()
            );
        }
    }
}
