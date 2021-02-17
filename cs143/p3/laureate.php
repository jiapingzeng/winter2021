<?php

$id = intval($_GET['id']);
$db = new mysqli("localhost", "cs143", "", "cs143");
if ($db->connect_errno > 0) {
    die("Unable to connect to database [" . $db->connect_error . "]");
}

header('Content-Type: application/json');



$id = 6;
$type = $db->query("SELECT type FROM Laureate WHERE id=$id;")->fetch_assoc()['type'];
print $type == "person";


if ($type == "person") {
    $row = $db->query("SELECT * FROM PERSON WHERE lid=$id;")->fetch_assoc();
    print $row;
} else if ($type == "organization") {
    $row = $db->query("SELECT * FROM Organization WHERE lid=$id;")->fetch_assoc();
    print $row;
} else {
    print "Could not find";
}

$output = (object) [
    "id" => strval($id),
    "type" => $type,
    "givenName" => (object) [
        "en" => "A. Michael"
    ],
    "familyName" => (object) [
        "en" => "Spencer"
    ],
    "affliations" => array(
        "UCLA",
        "White House"
    )
];
echo json_encode($output);
