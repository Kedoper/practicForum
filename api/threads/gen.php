<?php
header('Content-type: Application/json');
$faker = \Faker\Factory::create("RU_ru");

$response = [];


for ($i = 0; $i < 40; $i++) {
    $tmpTags = [];
    unset($c);
    for ($c = 0; $c < rand(1, 4); $c++) {
        $tmpTags[] = $faker->realText(10);
    }

    $new_thread = R::dispense('threads');
    $new_thread->title = $faker->realText(40);
    $new_thread->user_id = 1;
    $new_thread->category = $faker->realText(10);
    $new_thread->tags = json_encode($tmpTags);
    $new_thread->status = "open";
    $new_thread->likes = 0;
    $new_thread->replies = 0;
    $new_thread->views = 0;
    $new_thread->activity = rand(1, 24) . "H";
    $new_thread->created = $faker->unixTime('now');
    R::store($new_thread);
    unset($new_thread);

    $response['threads'][] = [
        'id' => $i + 1,
        'title' => $faker->realText(40),
        'category' => $faker->realText(10),
        'tags' => $tmpTags,
        'likes' => rand(0, 500),
        'replies' => rand(0, 500),
        'views' => rand(0, 6000),
        'activity' => rand(1, 24) . "H",
    ];

    unset($tmpCategory, $tmpTags);
}

$redis = new Redis;

$redis->connect('127.0.0.1', 6379);
$redis->select(1);
foreach ($response['threads'] as $thread) {
    $redis->set("thread_{$thread['id']}", json_encode($thread));
}
echo json_encode($response);