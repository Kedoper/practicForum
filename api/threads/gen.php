<?php
header('Content-type: Application/json');
$faker = \Faker\Factory::create("RU_ru");

$response = [];

$redis = new Redis;

$redis->connect('127.0.0.1', 6379);
$redis->select(1);

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
        'id' => $i + 1,
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

foreach ($response['threads'] as $thread) {
    $redis->set("thread_{$thread['id']}", json_encode($thread));
}
echo json_encode($response);