<?php

$id = intval($_GET['id']);
$db = new mysqli("localhost", "cs143", "", "cs143");
if ($db->connect_errno > 0) {
    die("Unable to connect to database [" . $db->connect_error . "]");
}

header('Content-Type: application/json');

$type = $db->query("SELECT type FROM Laureate WHERE id=$id;")->fetch_assoc()['type'];
$person = $db->query("SELECT * FROM Person WHERE Person.lid=$id;")->fetch_assoc();
$org = $db->query("SELECT * FROM Organization, Place WHERE lid=$id;")->fetch_assoc();

if ($person) {
    $birthplace = $db->query("SELECT * FROM Place WHERE id={$person['pid']};")->fetch_assoc();
    $birth = (object) [
        "date" => $person['birth'],
        "place" => (object) [
            "city" => (object) [
                "en" => $birthplace['city']
            ],
            "country" => (object) [
                "en" => $birthplace['country']
            ]
        ]
    ];
} elseif ($org) {
    $foundedplace = $db->query("SELECT * FROM Place WHERE id={$org['pid']};")->fetch_assoc();
    $founded = (object) [
        "date" => $org['founded'],
        "place" => (object) [
            "city" => (object) [
                "en" => $foundedplace['city']
            ],
            "country" => (object) [
                "en" => $foundedplace['country']
            ]
        ]
    ];
} else {
    echo json_encode((object) ["error" => "Invalid ID"]);
    return;
}

$nobelPrizes = [];
$prizeq = $db->query("SELECT * FROM NobelPrize WHERE lid=$id;");
while ($prow = $prizeq->fetch_assoc()) {

    $affiliations = [];
    $affilq = $db->query("SELECT * FROM Affiliation WHERE lid=$id;");
    while ($arow = $affilq->fetch_assoc()) {

        $affilplace = $db->query("SELECT * FROM Place WHERE id={$arow['pid']};")->fetch_assoc();
        $affiliations[] = (object) [
            "name" => (object) [
                "en" => $arow['name']
            ],
            "city" => (object) [
                "en" => $affilplace['city']
            ],
            "country" => (object) [
                "en" => $affilplace['country']
            ]
        ];
    }
    $nobelPrizes[] = (object) [
        "awardYear" => $prow['awardYear'],
        "category" => (object) [
            "en" => $prow['category']
        ],
        "sortOrder" => $prow['sortOrder'],
        "portion" => $prow['portion'],
        "dateAwarded" => $prow['dateAwarded'],
        "prizeStatus" => $prow['prizeStatus'],
        "motivation" => (object) [
            "en" => $prow['motivation']
        ],
        "prizeAmount" => $prow['prizeAmount'],
        "affiliations" => $affiliations
    ];
}

if ($person) {
    $output = (object) [
        "id" => $id,
        "givenName" => (object) [
            "en" => $person['givenName']
        ],
        "familyName" => (object) [
            "en" => $person['familyName']
        ],
        "gender" => $person['gender'],
        "birth" => $birth,
        "nobelPrizes" => $nobelPrizes
    ];
} elseif ($org) {
    $output = (object) [
        "id" => $id,
        "orgName" => $org['orgName'],
        "founded" => $founded,
        "nobelPrizes" => $nobelPrizes
    ];
}

echo json_encode($output);