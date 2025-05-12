<?php

namespace HalfShellStudios\FeedProcessor\Exceptions;

use Exception;

class FileIsMalformedException extends Exception
{
    public function __construct(string $error)
    {
        parent::__construct('File is malformed: ' . $error);
    }
}
