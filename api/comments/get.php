<?php
$data = json_decode(file_get_contents("php://input"), true);
$response = [];

$comments = R::findCollection('comments', 'WHERE thread_id =? ORDER BY `datetime` DESC', [$data['thread']]);

while ($comment = $comments->next()) {
    $author = R::load('users', $comment['user_id']);
    $response[] = [
        'author' => $author['login'],
        'datetime' => date('d.m.Y H:i', $comment['datetime']),
        'content' => json_decode($comment['content'], true),
        'like' => count(json_decode($comment['likes']), true),
        'dislike' => count(json_decode($comment['dislikes']), true),
        'fav' => count(json_decode($comment['fav']), true),
    ];
}

print_r(json_encode($response));