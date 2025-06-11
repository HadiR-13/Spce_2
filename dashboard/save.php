<?php

$planets = json_decode(file_get_contents("../data/planets.json"), true);

if (!empty($_POST['planets'])) {
    foreach ($_POST['planets'] as $index => $planetUpdate) {
        $positionParts = explode(',', $planetUpdate['position']);
        $planets[$index] = array_merge($planets[$index], [
            'cost' => $planetUpdate['cost'],
            'distance' => $planetUpdate['distance'],
            'estimasi' => $planetUpdate['estimasi'],
            'description' => $planetUpdate['description'],
            'detailDescription' => $planetUpdate['detailDescription'],
            'file' => $planetUpdate['file'],
            'scale' => floatval($planetUpdate['scale']),
            'position' => [
                'x' => floatval($positionParts[0] ?? 0),
                'y' => floatval($positionParts[1] ?? 0),
                'z' => floatval($positionParts[2] ?? 0),
            ],
        ]);
    }
}

if (!empty($_POST['new']['name'])) {
    $positionParts = explode(',', $_POST['new']['position']);
    $planets[] = [
        'name' => $_POST['new']['name'],
        'file' => $_POST['new']['file'],
        'scale' => floatval($_POST['new']['scale']),
        'position' => [
            'x' => floatval($positionParts[0] ?? 0),
            'y' => floatval($positionParts[1] ?? 0),
            'z' => floatval($positionParts[2] ?? 0),
        ],
        'description' => $_POST['new']['description'],
        'detailDescription' => $_POST['new']['detailDescription'],
        'distance' => $_POST['new']['distance'],
        'estimasi' => $_POST['new']['estimasi'],
        'cost' => $_POST['new']['cost']
    ];
}

file_put_contents("../data/planets.json", json_encode($planets, JSON_PRETTY_PRINT));
header("Location: ./form_edit.php");
exit;
