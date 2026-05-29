<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$controller = new \App\Http\Controllers\MahasiswaController();
$response = $controller->apiGetRooms();
echo $response->getContent();
