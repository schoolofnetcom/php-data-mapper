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

$user = new Users([
    'name' => 'João',
    'email' => 'j@jasd.com',
    'password' => '654321'
]);

$repository = new Repository($conn);
$repository->setEntity(Users::class);
$users = $repository->all();
var_dump($users);