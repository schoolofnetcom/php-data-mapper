<?php

require __DIR__  .'/vendor/autoload.php';

use ErikFig\DataMapperOrm\Drivers\Mysql;
use ErikFig\DataMapperOrm\Repositories\Repository;
use App\Entities\Users;

$conn = new Mysql;

$conn->connect([
    'server' => 'localhost',
    'database' => 'curso_php_data_mapper',
    'user' => 'root'
]);

$repository = new Repository($conn);
$repository->setEntity(Users::class);
$users = $repository->first(1);
var_dump($users);