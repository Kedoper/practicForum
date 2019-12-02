<?php
$data = json_decode(file_get_contents("php://input"), true);

$actionList = [
    'like' => "threadLikeAction",
    'dislike' => "threadDislikeAction",
    'fav' => "threadFavAction",
    'report' => "threadReportAction",
    'delete' => "threadDeleteAction",
    'close' => "threadCloseAction",
    'edit' => "threadEditAction",
];

$actionType = $data['action'];

function threadLikeAction () {
    echo __FUNCTION__;
}
function threadDislikeAction () {
    echo __FUNCTION__;
}
function threadFavAction () {
    echo __FUNCTION__;
}
function threadReportAction () {
    echo __FUNCTION__;
}
function threadDeleteAction () {
    echo __FUNCTION__;
}
function threadCloseAction () {
    echo __FUNCTION__;
}
function threadEditAction () {
    echo __FUNCTION__;
}

if (key_exists($actionType, $actionList)) {
    call_user_func($actionList[$actionType], $data);
} else {
    echo "BAD";
}