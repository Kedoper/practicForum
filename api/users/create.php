<?php
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/objects/Privileges.php";
$data = json_decode(file_get_contents("php://input"), true);
$response = [];


function existsUser($userName)
{
    $user = R::findOne('users', 'login = ?', [$userName]);
    return $user;
}

function createUser($data): bool
{
    $tmpResponse = [];
//    if (!key_exists("userLogin", $data) || $data['userLogin'] === null || $data['userLogin'] === "") {
//        $tmpResponse = [
//            'code' => -1,
//            'message' => 'Вы ввели пустые данные',
//        ];
//    }
    $newUser = R::dispense('users');
    $newUser->login = $data['userLogin'];
    $newUser->email = $data['userEmail'];
    $newUser->password = password_hash($data['userPassword'], PASSWORD_DEFAULT);
    $newUser->privileges = Privileges::getDefaultMask();
    $newUser->registered = time();
    $newUser->avatar = "https://avatars0.githubusercontent.com/u/23498262?s=460&v=4";
    $newUser->punishment = json_encode([]);
    $newUser->last_login = time();
    $newUser->likes = json_encode([]);
    $newUser->dislikes = json_encode([]);
    $newUser->favs = json_encode([]);
    $newUser->api_tokens = json_encode([
        [
            'token' => hash('sha256', random_bytes(9999)),
            'lifetime' => 0,
            'comment' => "For access to website."
        ]
    ]);
    $user_id = R::store($newUser);

    $_SESSION['logged_user'] = R::load('users', $user_id)->export();

    unset($_SESSION['logged_user']['password']);

    return true;
}

function loginUser($data): array
{
}


createUser($data);
//existsUser("tester");
//
//switch ($data['formAction']) {
//    case "register":
//        $response = createUser($data);
//        break;
//    case "login":
//        $response = loginUser($data);
//        break;
//}

print_r(json_encode($response));