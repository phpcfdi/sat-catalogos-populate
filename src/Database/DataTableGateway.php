<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

use LogicException;
use PDOException;

class DataTableGateway
{
    public function __construct(private readonly DataTable $dataTable, private readonly Repository $repository)
    {
    }

    public function dataTable(): DataTable
    {
        return $this->dataTable;
    }

    public function recreate(): void
    {
        $this->drop();
        $this->create();
    }

    private function sqlDiscoverField(DataFieldInterface $field): string
    {
        if ($field instanceof PreprocessDataField) {
            return $this->sqlDiscoverField($field->getNextDataField());
        }
        $sqlName = $this->repository->escapeName($field->name());
        if ($field instanceof TextDataField || $field instanceof DateDataField) {
            return $sqlName . ' text not null';
        }
        if ($field instanceof IntegerDataField || $field instanceof BoolDataField) {
            return $sqlName . ' int not null';
        }
        if ($field instanceof FloatDataField) {
            return $sqlName . ' real not null';
        }

        throw new LogicException("Don't know what to do with " . $field::class);
    }

    public function drop(): void
    {
        $sql = 'DROP TABLE IF EXISTS ' . $this->repository->escapeName($this->dataTable->name()) . ';';
        $this->repository->execute($sql);
    }

    public function create(): void
    {
        $fields = [];
        foreach ($this->dataTable->fields() as $field) {
            $fields[] = $this->sqlDiscoverField($field);
        }

        $pkDefinition = '';
        if (count($this->dataTable->primaryKey()) > 0) {
            $pkDefinition = 'PRIMARY KEY ('
                . implode(', ', array_map(
                    fn (string $input): string => $this->repository->escapeName($input),
                    $this->dataTable->primaryKey()
                ))
                . ')';
        }

        $sql = 'CREATE TABLE ' . $this->repository->escapeName($this->dataTable->name())
            . ' ( ' . implode(', ', array_filter([...$fields, ...[$pkDefinition]])) . ' )'
            . ';';
        $this->repository->execute($sql);
    }

    /** @param mixed[] $input */
    public function insert(array $input): void
    {
        $sql = $this->sqlInsert('INSERT INTO');

        try {
            $this->repository->execute($sql, $input);
        } catch (PDOException $exception) {
            $message = sprintf('Unable to run %s using %s', $sql, json_encode($input, JSON_THROW_ON_ERROR));
            throw new PDOException($message, 0, $exception);
        }
    }

    /** @param mixed[] $input */
    public function replace(array $input): void
    {
        $sql = $this->sqlInsert('REPLACE INTO');

        try {
            $this->repository->execute($sql, $input);
        } catch (PDOException $exception) {
            $message = sprintf('Unable to run %s using %s', $sql, json_encode($input, JSON_THROW_ON_ERROR));
            throw new PDOException($message, 0, $exception);
        }
    }

    private function sqlInsert(string $sqlCommand): string
    {
        $fieldNames = [];
        $preparedNames = [];
        foreach ($this->dataTable->fields() as $dataField) {
            $fieldNames[] = $this->repository->escapeName($dataField->name());
            $preparedNames[] = ':' . $dataField->name();
        }

        return $sqlCommand . ' ' . $this->repository->escapeName($this->dataTable->name())
            . ' (' . implode(', ', $fieldNames) . ')'
            . ' VALUES (' . implode(', ', $preparedNames) . ')'
            . ';';
    }
}
