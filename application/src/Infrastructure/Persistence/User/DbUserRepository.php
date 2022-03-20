<?php


namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Domain\User\UserType;
use App\Infrastructure\Db\DatabaseInterface;

class DbUserRepository implements UserRepository
{
    private DatabaseInterface $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    /**
     * @throws UserNotFoundException
     */
    public function findByEmail(string $email): ?User
    {
        $result = $this->db->fetch(
            "SELECT id, email, role FROM app.user WHERE email = :email",
            ['email' => $email]
        );

        if (empty($result)) {
            return throw new UserNotFoundException();
        }

        return new User($result['id'], $result['email'], $result['role']);
    }

    public function getManagerEmails(): ?array
    {
        $result = $this->db->fetchAll(
            "SELECT email FROM app.user WHERE role = :role",
            ['role' => UserType::MANAGER]
        );

        if (empty($result)) {
            return null;
        }

        return array_map(fn($r) => $r['email'], $result);
    }
}
