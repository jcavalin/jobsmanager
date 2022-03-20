<?php

namespace App\Infrastructure\Command;

use Exception;

abstract class AbstractCommand implements CommandInterface
{
    /**
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        if (php_sapi_name() !== 'cli') {
            throw new Exception('Command can only be called from CLI');
        }
    }
}