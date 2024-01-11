<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

use PDO;
use PDOException;
use RuntimeException;

class Repository
{
    private readonly PDO $pdo;

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
     * @return array<int, array<string, string|null>>
     */
    public function queryArray(string $sql, array $values = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        if (false === $stmt->execute($values)) {
            throw new RuntimeException("Unable to execute $sql");
        }
        $table = [];
        while (false !== $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            /** @var array<string, scalar|null> $row */
            $table[] = $this->convertScalarNullToStringArray($row);
        }

        return $table;
    }

    /**
     * @param mixed[] $values
     * @return array<string, string|null>
     */
    public function queryRow(string $sql, array $values = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        if (false === $stmt->execute($values)) {
            throw new RuntimeException("Unable to execute $sql");
        }
        /** @var false|array<string, scalar|null> $row */
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (! is_array($row)) {
            return [];
        }
        return $this->convertScalarNullToStringArray($row);
    }

    /** @param array<string, scalar|null> $values */
    public function queryOne(string $sql, array $values = []): ?string
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $this->convertScalarNullToStringValue($stmt->fetchColumn(0));
    }

    public function escapeName(string $name): string
    {
        return '"' . str_replace('"', '""', $name) . '"';
    }

    /** @param scalar|null $value */
    private function convertScalarNullToStringValue($value): ?string
    {
        return (null === $value) ? null : (string) $value;
    }

    /**
     * @param array<scalar|null> $values
     * @return array<string|null>
     */
    private function convertScalarNullToStringArray(array $values): array
    {
        return array_map(
            fn ($value): ?string => $this->convertScalarNullToStringValue($value),
            $values
        );
    }
}
