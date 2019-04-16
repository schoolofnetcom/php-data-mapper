<?php

namespace ErikFig\DataMapperOrm\QueryBuilder;

use ErikFig\DataMapperOrm\QueryBuilder\Filters\Where;

class Select implements QueryBuilderInterface
{
    use Where;

    private $query;
    protected $values = [];

    public function __construct(string $table, $conditions = [])
    {
        $this->query = $this->makeSql($table,  $conditions);
    }

    private function makeSql($table,  $conditions)
    {
        $sql = sprintf('SELECT * FROM %s', $table);

        if ($conditions) {
            $sql .= $this->makeWhere($conditions);
        }

        return $sql;
    }

    public function getValues() :array
    {
        return $this->values;
    }

    public function __toString()
    {
        return $this->query;
    }
}
