<?php

namespace App\Application\Actions;

use Psr\Http\Message\ServerRequestInterface;

class Validation
{
    /**
     * @throws ValidationException
     */
    public function required(ServerRequestInterface $request, array $params, string $name): static
    {
        if (empty($params[$name])) {
            throw new ValidationException($request, "The param '{$name}' is required.");
        }

        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function maxLength(ServerRequestInterface $request, array $params, string $name, int $maxlength): static
    {
        if (strlen($params[$name]) > $maxlength) {
            throw new ValidationException($request, "The param '{$name}' length is greater than {$maxlength}.");
        }

        return $this;
    }
}