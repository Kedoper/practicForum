<?php
$redis = new Redis;

$redis->connect('127.0.0.1', 6379);

$sd =$redis->keys('*');

print_r($sd);