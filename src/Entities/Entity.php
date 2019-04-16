<?php

namespace ErikFig\DataMapperOrm\Entities;

class Entity implements EntityInterface
{
    protected $data;
    protected $table;

    public function __construct(array $data = [])
    {

    }

    public function setAll(array $data)
    {
        $this->data = $data;
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function getTable(): string
    {
        return 'users';
    }
}