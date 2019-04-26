<?php

require __DIR__  .'/vendor/autoload.php';

use ErikFig\DataMapperOrm\Drivers\Mysql as Driver;
use ErikFig\DataMapperOrm\Repositories\Repository;
use App\Entities\Users;

$conn = new Driver;

$conn->connect([
    'server' => 'localhost',
    'database' => 'curso_php_data_mapper',
    'user' => 'root'
]);

$repository = new Repository($conn);
$repository->setEntity(Users::class);

$user = $repository->first(1);
$user->name = 'Erik Figueiredo';

$user = $repository->update($user);
var_dump($user);