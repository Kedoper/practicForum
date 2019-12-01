<?php
$data = json_decode(file_get_contents("php://input"), true);

$response = [];

$newComment = R::dispense('comments');
$newComment->user_id = 1;
$newComment->content = json_encode($data['comment']);
$newComment->thread_id = $data['thread'];
$newComment->datetime = time();
$newComment->likes = 0;
$newComment->dislikes = 0;
$newComment->fav = 0;
$newComment->reports = 0;
$newComment->answer = false;
$newComment->hidden = false;
$newComment_id = R::store($newComment);

$response['comment_id'] = $newComment_id;
print_r(json_encode($response));


