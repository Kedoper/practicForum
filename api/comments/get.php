<?php
$data = json_decode(file_get_contents("php://input"), true);
$response = [];

$comments = R::findCollection('comments', 'WHERE thread_id =? ORDER BY `datetime` DESC', [$data['thread']]);

while ($comment = $comments->next()) {
    $response[] = [
        'datetime' => date('d.m.Y H:i',$comment['datetime']),
        'content' => json_decode($comment['content'], true),
        'like' => $comment['likes'],
        'dislike' => $comment['dislikes'],
        'fav' => $comment['fav'],
    ];
}

print_r(json_encode($response));