<?php
include dirname(__DIR__) . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
$dotenv->load();
$_callType = 'cron';
include dirname(__DIR__) . '/libs/rb/connect.php';
/*
 * Данный скрипт обновляет таблицу тем в Redis каждые 20 минут.
 *
 * Индекс базы для хранения тем - 1
 * */

file_put_contents(dirname(__DIR__) . '/logs/cron/updateThreads.log', '[' . date("d.m.Y H:i:s") . "] | Starting cron work\n", FILE_APPEND);

$redis = new Redis;

$redis->connect('127.0.0.1');

$redis->select(1);

$threadsList = R::findCollection('threads');

$redis->multi();
$redis->flushDB();
while ($thread = $threadsList->next()) {
    $thread_ = $thread->export();
    $threadComments = R::count('comments', 'WHERE thread_id = ?', [$thread['id']]);

    $thread_['replies'] = $threadComments;
    $thread_['tags'] = json_decode($thread_['tags'], true);
    $redis->set("thread_{$thread['id']}", json_encode($thread_));
}
$redis->exec();
file_put_contents(dirname(__DIR__) . '/logs/cron/updateThreads.log', '[' . date("d.m.Y H:i:s") . "] | Success end cron work\n", FILE_APPEND);
