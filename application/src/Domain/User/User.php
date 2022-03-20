<?php


namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable
{
    private ?int $id;

    private string $email;

    private string $role;

    public function __construct(?int $id, string $email, string $role)
    {
        $this->id    = $id;
        $this->email = $email;
        $this->role  = $role;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'email' => $this->email,
            'role'  => $this->role
        ];
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function isManager(): bool
    {
        return $this->role === UserType::MANAGER;
    }
}
