<?php

namespace ErikFig\DataMapperOrm\Entities;

class Entity implements EntityInterface
{
    protected $data;
    protected $table;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function setAll(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function getTable(): string
    {
        if (!empty($this->table)) {
            return $this->table;
        }

        $table = get_class($this); // App\Entities\Users
        $table = explode('\\', $table); // [ 'App', 'Entities','Users' ]
        $table = array_pop($table); // Users
        
        return strtolower($table);
    }

    public function __get($name)
    {
        $method = $this->methodName('get', $name);

        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return $this->data[$name];
    }

    public function __set($name, $value)
    {
        $method = $this->methodName('set', $name);

        if (method_exists($this, $method)) {
            return $this->$method($value);
        }
        return $this->data[$name];
    }

    private function methodName($prefix, $name)
    {
        $method = str_replace('_', ' ', $name);
        $method = ucwords($method);
        $method = str_replace(' ', '', $method);

        return $prefix . $method;
    }
}