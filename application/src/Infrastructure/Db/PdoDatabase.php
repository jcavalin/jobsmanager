<?php

namespace App\Infrastructure\Db;

use PDO;
use PDOStatement;

class PdoDatabase implements DatabaseInterface
{
    protected PDO $pdo;

    public function __construct(
        string $connection,
        string $host,
        string $dbname,
        string $username,
        string $password
    )
    {
        $this->pdo = new PDO(
            "{$connection}:host={$host};dbname={$dbname}",
            $username,
            $password
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->execute($sql, $params)->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function save(string $sql, array $params): int
    {
        $this->execute($sql, $params);

        return $this->pdo->lastInsertId();
    }

    protected function execute(string $sql, array $params = []): PDOStatement
    {
        $stm = $this->pdo->prepare($sql);
        $stm->execute($params);

        return $stm;
    }

    public function fetch(string $sql, array $params = []): array
    {
        $result = $this->execute($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return [];
        }

        return $result[0];
    }
}