<?php

namespace ErikFig\DataMapperOrm\QueryBuilder;

use ErikFig\DataMapperOrm\QueryBuilder\Filters\Where;

class Update implements QueryBuilderInterface
{
    use Where;

    private $query;
    protected $values = [];

    public function __construct(string $table, array $data, $conditions = [])
    {
        $this->values = array_values($data);
        $this->query = $this->makeSql($table, $data,  $conditions);
    }

    private function makeSql($table, $data,  $conditions)
    {
        $sql = sprintf('UPDATE %s', $table);

        $columns = array_keys($data);

        $columns_query = [];
        foreach ($colums as $column) {
            $columns_query[] = $column . '=?';
        }

        $sql . ' SET ' . implode(', ', $columns_query);
        $sql .= $this->makeWhere($conditions);

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
