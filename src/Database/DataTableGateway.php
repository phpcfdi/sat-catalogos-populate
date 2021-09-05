<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

use LogicException;
use PDOException;

class DataTableGateway
{
    private DataTable $dataTable;

    private Repository $repository;

    public function __construct(DataTable $dataTable, Repository $repository)
    {
        $this->dataTable = $dataTable;
        $this->repository = $repository;
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

        throw new LogicException("Don't know what to do with " . get_class($field));
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

    public function insert(array $input): void
    {
        $fieldNames = [];
        $preparedNames = [];
        foreach ($this->dataTable->fields() as $dataField) {
            $fieldNames[] = $this->repository->escapeName($dataField->name());
            $preparedNames[] = ':' . $dataField->name();
        }

        $sql = 'INSERT INTO ' . $this->repository->escapeName($this->dataTable->name())
            . ' (' . implode(', ', $fieldNames) . ')'
            . ' VALUES (' . implode(', ', $preparedNames) . ')'
            . ';';

        try {
            $this->repository->execute($sql, $input);
        } catch (PDOException $exception) {
            $message = sprintf('Unable to run %s using %s', $sql, json_encode($input, JSON_THROW_ON_ERROR));
            throw new PDOException($message, 0, $exception);
        }
    }
}
