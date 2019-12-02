<?php
include __DIR__ . "/rb-mysql.php";
$host = getenv("DB_HOST");
$db_name = getenv("DB_NAME");
$db_userName = getenv("DB_USER_NAME");
$db_password = getenv("DB_PASSWORD");
R::setup("mysql:host={$host};dbname={$db_name}",
    $db_userName, $db_password);

R::ext('xdispense', function ($type) {
    return R::getRedBean()->dispense($type);
});

//session_save_path($_SERVER['DOCUMENT_ROOT'].'/tmp/sessions');

/* Запуск сессии только в том случае, если это не cron-задача */
if (!$_callType || $_callType === null || $_callType !== "cron") {
    /* Сессии хранятся в Redis */
    session_start();
}

if (!R::testConnection()) {
    throw new Exception("Error to connect database");
}