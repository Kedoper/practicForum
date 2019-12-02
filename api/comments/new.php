<?php
$data = json_decode(file_get_contents("php://input"), true);

$response = [];

$newComment = R::dispense('comments');
$newComment->user_id = 1;
$newComment->content = json_encode($data['comment']);
$newComment->thread_id = $data['thread'];
$newComment->datetime = time();
$newComment->likes = json_encode([]);
$newComment->dislikes = json_encode([]);
$newComment->fav = json_encode([]);
$newComment->reports = json_encode([]);
$newComment->answer = false;
$newComment->hidden = false;
$newComment_id = R::store($newComment);

$response['comment_id'] = $newComment_id;
print_r(json_encode($response));


