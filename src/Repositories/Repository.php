<?php

namespace ErikFig\DataMapperOrm\Repositories;

use ErikFig\DataMapperOrm\Drivers\DriverInterface;
use ErikFig\DataMapperOrm\Entities\EntityInterface;
use ErikFig\DataMapperOrm\QueryBuilder\Select;
use ErikFig\DataMapperOrm\QueryBuilder\Insert;
use ErikFig\DataMapperOrm\QueryBuilder\Delete;
use ErikFig\DataMapperOrm\QueryBuilder\Update;
use ErikFig\DataMapperOrm\Entities\Entity;

class Repository
{
    protected $driver;

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function setEntity(string $entity)
    {
        $reflection = new \ReflectionClass($entity);

        if (!$reflection->implementsInterface(EntityInterface::class)) {
            throw new \InvalidArgumentException("{$entity} not implements interface " . EntityInterface::class);
        }

        $this->entity = $entity;
    }

    public function getEntity(): EntityInterface
    {
        if (is_null($this->entity)) {
            # return new Entity;
            throw new \Exception('entity is required');
        }

        if (is_string($this->entity)) {
            return new $this->entity;
        }
    }

    public function insert(EntityInterface $entity): EntityInterface
    {
        $table = $entity->getTable();
        $this->driver->setQueryBuilder(new Insert($table, $entity->getAll()));
        $this->driver->execute();
        
        return $this->first($this->driver->lastInsertedId());
    }

    public function update(EntityInterface $entity): EntityInterface
    {
        $table = $entity->getTable();
        $condition = [
            ['id', $entity->id]
        ];

        $this->driver->setQueryBuilder(new Update($table, $entity->getAll(), $condition));
        $this->driver->execute();
        
        return $entity;
    }

    public function delete(EntityInterface $entity): EntityInterface
    {
        $table = $entity->getTable();
        $condition = [
            ['id', $entity->id]
        ];
        $this->driver->setQueryBuilder(new Delete($table, $condition));
        $this->driver->execute();
        
        return $entity;
    }

    public function first($id = null): ?EntityInterface
    {
        $entity = $this->getEntity();
        $table = $entity->getTable();

        $conditions = [];

        if (!is_null($id)) {
            $conditions[] = ['id', $id];
        }

        $this->driver->setQueryBuilder(new Select($table, $conditions));
        $this->driver->execute();

        $data = $this->driver->first();
        if (!$data) {
            return null;
        }
        return $entity->setAll($data);
    }

    public function all(array $conditions = []): array
    {
        $entity = $this->getEntity();
        $table = $entity->getTable();
        $this->driver->setQueryBuilder(new Select($table, $conditions));
        $this->driver->execute();
        $data = $this->driver->all();
        
        $entities = [];
        foreach ($data as $row) {
            $entities[] = new $this->entity($row);
        }

        return $entities;
    }
}
