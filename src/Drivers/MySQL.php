<?php

namespace ErikFig\DataMapperOrm\Drivers;

use ErikFig\DataMapperOrm\QueryBuilder\QueryBuilderInterface;

class MySQL implements DriverInterface
{
    protected $dsn_pattern = 'mysql:host=%s;dbname=%s';

    use PDOTrait;
}
