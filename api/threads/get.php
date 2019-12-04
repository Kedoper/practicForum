<?php
header('Content-type: Application/json');
$response = [];

$redis = new Redis;

$redis->connect('127.0.0.1', 6379);
$redis->select(1);

$threads = $redis->keys("*");
$tmp = [];
foreach ($threads as $thread) {
    $th = json_decode($redis->get($thread), true);
    $tmp[$th['id']] = $th;
    $author = R::load('users', $th['user_id']);
    $tmp[$th['id']]['author'] = [
        'id' => $author['id'],
        'login' => $author['login'],
        'avatar' => $author['avatar']
    ];
    unset($author);
    unset($th);
//    $tmp[$th['id']]['tags'] = json_decode($th['tags'], true);
}
ksort($tmp);
$response['threads'] = $tmp;
print_r(json_encode($response));