<?php

namespace App\Infrastructure\Db;

interface DatabaseInterface
{
    public function __construct(
        string $connection,
        string $host,
        string $dbname,
        string $username,
        string $password
    );

    public function fetchAll(string $sql, array $params = []): array;

    public function fetch(string $sql, array $params = []): array;

    public function save(string $sql, array $params): int;
}