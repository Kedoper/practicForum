<?php

include dirname(__DIR__) . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
$dotenv->load();
$_callType = 'cron';
include dirname(__DIR__) . '/libs/rb/connect.php';

/* Данный скрипт обновляет базу данных существующих пользователей и занятых почт, которые
    находятся в Redis
 */
file_put_contents(dirname(__DIR__) . '/logs/cron/updateUsersAndMails.log', '[' . date("d.m.Y H:i:s") . "] | Starting cron work\n", FILE_APPEND);


$redis = new Redis;

$redis->connect('127.0.0.1');



file_put_contents(dirname(__DIR__) . '/logs/cron/updateUsersAndMails.log', '[' . date("d.m.Y H:i:s") . "] | Success end cron work\n", FILE_APPEND);
