<?php

$redis = new Redis;

$redis->connect('127.0.0.1');

$redis->select(1);

$data = json_decode(file_get_contents("php://input"), true);

$text = "<h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit.&nbsp;</h3><div>Autem est laborum perferendis porro praesentium repellat. Ad, aliquid, amet architecto eaque eligendi facilis fuga harum in ipsam assasaslaboriosam odit perspiciatis temporibus.</div><div>Autem est laborum perferendis porro praesentium repellat. Ad, aliquid, amet architecto eaque eligendi facilis fuga harum in ipsam assasaslaboriosam odit perspiciatis temporibus.<br></div><div>Autem est laborum perferendis porro praesentium repellat. Ad, aliquid, amet architecto eaque eligendi facilis fuga harum in ipsam assasaslaboriosam odit perspiciatis temporibus.<br></div><div><br></div><div>Autem est laborum perferendis porro praesentium repellat. Ad, aliquid, amet architecto eaque eligendi facilis fuga harum in ipsam assasaslaboriosam odit perspiciatis temporibus.<br></div><div>Autem est laborum perferendis porro praesentium repellat. Ad, aliquid, amet architecto eaque eligendi facilis fuga harum in ipsam assasaslaboriosam odit perspiciatis temporibus.<br></div><div><br></div><div><h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit.&nbsp;</h3></div><div><div>Autem est laborum perferendis porro praesentium repellat. Ad, aliquid, amet architecto eaque eligendi facilis fuga harum in ipsam assasaslaboriosam odit perspiciatis temporibus autem est laborum perferendis porro praesentium repellat. Ad, aliquid, amet architecto eaque eligendi facilis fuga harum in ipsam assasaslaboriosam odit perspiciatis temporibus.</div></div>";

$thread = $redis->get("thread_{$data['thread_id']}");
if ($thread) {
    $thread = json_decode($thread, true);

    $response = $thread;
    $response['content'] = $text;
} else {
    $response = [];
}

print_r(json_encode($response));


//$response['tags'] = json_decode($thread['tags'], true);
//print_r(json_encode([
//    'thread_id' => $thread['id'],
//    'category' => $thread['category'],
//    'tags' => json_decode($thread['tags'], true),
//    'content' => $text,
//    'title' => $thread['title'],
//    'likes' => $thread['likes'],
//    'replies' => $thread['replies'],
//    'views' => $thread['views'],
//]));