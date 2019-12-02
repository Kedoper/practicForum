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
}
ksort($tmp);
$response['threads'] = $tmp;
print_r(json_encode($response));