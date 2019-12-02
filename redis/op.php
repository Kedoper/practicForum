<?php
declare(ticks=1);
$redis = new Redis;

$redis->connect('127.0.0.1', 6379);
//$redis->select(2);
for ($i = 0; $i < 999; $i++) {
    $redis
        ->set("test-$i", hash_hmac('sha256', random_bytes(999), "sdji$i"));
}
//$redis->flushAll();

