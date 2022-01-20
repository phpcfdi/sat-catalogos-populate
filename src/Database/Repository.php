<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

use PDO;
use PDOException;
use RuntimeException;

class Repository
{
    private PDO $pdo;

    public function __construct(string $dbfile)
    {
        if (':memory:' !== $dbfile) {
            // TODO: validate other sources ?
            $dbfile = '//' . $dbfile;
        }
        $this->pdo = new PDO('sqlite:' . $dbfile, '', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    public function hasTable(string $table): bool
    {
        $sql = 'SELECT count(*) FROM sqlite_master WHERE type = :type AND name = :table;';
        return (1 === (int) $this->queryOne($sql, ['type' => 'table', 'table' => $table]));
    }

    public function getRecordCount(string $table): int
    {
        $sql = 'SELECT count(*) FROM ' . $this->escapeName($table) . ';';
        return (int) $this->queryOne($sql);
    }

    /**
     * @param mixed[] $values
     */
    public function execute(string $sql, array $values = []): void
    {
        $stmt = $this->pdo->prepare($sql);
        if (false === $stmt->execute($values)) {
            $errorInfo = $stmt->errorInfo();
            throw new PDOException(sprintf('[%s] %s', $errorInfo[1] ?? 'UNDEF', $errorInfo[2] ?? 'Unknown error'));
        }
    }

    /**
     * @param mixed[] $values
     * @return array<int, array<string, scalar|null>>
     */
    public function queryArray(string $sql, array $values = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        if (false === $stmt->execute($values)) {
            throw new RuntimeException("Unable to execute $sql");
        }
        $table = [];
        while (false !== $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            /** @var array<scalar|null> $row */
            $table[] = $row;
        }

        return $table;
    }

    /**
     * @param mixed[] $values
     * @return array<string, scalar|null>
     */
    public function queryRow(string $sql, array $values = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        if (false === $stmt->execute($values)) {
            throw new RuntimeException("Unable to execute $sql");
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            return $row;
        }

        return [];
    }

    /**
     * @param mixed[] $values
     * @return scalar|null
     */
    public function queryOne(string $sql, array $values = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchColumn(0);
    }

    public function escapeName(string $name): string
    {
        return '"' . str_replace('"', '""', $name) . '"';
    }
}
