<?php


namespace App\Domain\User;

interface UserRepository
{
    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
}
