<?php
header('Content-type: Application/json');
$faker = \Faker\Factory::create();

$response = [];


for ($i = 0; $i < 40; $i++) {
    $tmpCategory = [];
    $tmpTags = [];
    for ($c = 0; $c < rand(1, 3); $c++) {
        $tmpCategory[] = $faker->realText(10);
    }
    unset($c);
    for ($c = 0; $c < rand(1, 4); $c++) {
        $tmpTags[] = $faker->realText(10);
    }
    $response['threads'][] = [
        'id' => rand(1, 9999),
        'title' => $faker->realText(40),
        'category' => $tmpCategory,
        'tags' => $tmpTags,
        'likes' => rand(0, 500),
        'replies' => rand(0, 500),
        'views' => rand(0, 6000),
        'activity' => rand(1, 24) . "H",
    ];

    unset($tmpCategory, $tmpTags);
}


echo json_encode($response);