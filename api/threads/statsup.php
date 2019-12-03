<?php
header('Content-type: Application/json');
$data = json_decode(file_get_contents("php://input"), true);
$response = [];


$redis = new Redis;

$redis->connect('127.0.0.1');
$redis->select(1);


$thread = R::load('threads', $data['thread_id']);
$thread->views = $thread->views + 1;
R::store($thread);

$redis->set("thread_{$data['thread_id']}", json_encode(R::load('threads', $data['thread_id'])->export()));

print_r(json_encode($response));