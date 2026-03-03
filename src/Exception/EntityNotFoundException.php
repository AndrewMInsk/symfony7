<?php

namespace App\Exception;

use RuntimeException;

class EntityNotFoundException extends RuntimeException
{
    public function __construct(string $entityName, int $id)
    {
        parent::__construct(sprintf('%s with id %d not found', $entityName, $id), 404);
    }
}
