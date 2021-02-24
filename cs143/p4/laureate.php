<?php

$id = intval($_GET['id']);
header('Content-Type: application/json');

$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$query = new MongoDB\Driver\Query([
    "id" => "$id"
], [
    "projection" => ["_id" => 0]
]);
$rows = $mng->executeQuery("nobel.laureates", $query);

foreach ($rows as $row) {
    echo json_encode($row);
}
