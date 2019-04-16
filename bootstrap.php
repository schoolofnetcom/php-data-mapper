<?php

require __DIR__  .'/vendor/autoload.php';

$select = new ErikFig\DataMapperOrm\QueryBuilder\Select('users');

$conn = new ErikFig\DataMapperOrm\Drivers\Mysql;

$conn->connect([
    'server' => 'localhost',
    'database' => 'curso_php_data_mapper',
    'user' => 'root'
]);

$conn->setQueryBuilder($select);
$conn->execute();
$users = $conn->all();

var_dump($users[0]['name']);