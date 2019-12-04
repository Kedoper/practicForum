<?php
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT'] . "/objects/Privileges.php";
$data = json_decode(file_get_contents("php://input"), true);
$response = [];


function existsUser($userName, $userEmail): array
{
    $user = R::findOne('users', 'login = ?', [$userName]);
    $email = R::findOne('users', 'email = ?', [$userEmail]);
    return [
        'email' => $email,
        'user' => $user
    ];
}

function createUser($data): array
{
    $tmpResponse = [];
    if (!key_exists("userLogin", $data) || $data['userLogin'] === null || $data['userLogin'] === "") {
        $tmpResponse = [
            'code' => -1,
            'message' => 'Вы ввели пустые данные',
        ];
    }
    if (!key_exists("userEmail", $data) || $data['userEmail'] === null || $data['userEmail'] === "") {
        $tmpResponse = [
            'code' => -1,
            'message' => 'Вы ввели пустые данные',
        ];
    }
    if (!key_exists("userPassword", $data) || $data['userPassword'] === null || $data['userPassword'] === "") {
        $tmpResponse = [
            'code' => -1,
            'message' => 'Вы ввели пустые данные',
        ];
    }


    if (!key_exists('code', $tmpResponse)) {

        $searchedUser = existsUser($data['userLogin'], $data['userEmail']);

        if ($searchedUser['user'] === null && $searchedUser['email'] === null) {
            $newUser = R::dispense('users');
            $newUser->login = $data['userLogin'];
            $newUser->email = $data['userEmail'];
            $newUser->password = password_hash($data['userPassword'], PASSWORD_DEFAULT);
            $newUser->privileges = Privileges::getDefaultMask();
            $newUser->registered = time();
            $newUser->avatar = "";
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
            $tmpResponse = [
                'code' => 0
            ];
            return $tmpResponse;
        }
        $tmpResponse = [
            'code' => -2,
            'message' => 'Пользователь с данным логином или почтой уже есть',
        ];
        return $tmpResponse;
    }
    $tmpResponse = [
        'code' => -1,
        'message' => 'Некоторые поля не заполнены',
    ];
    return $tmpResponse;
}

function loginUser($data): array
{
    $user = R::findOne('users', 'login = ?', [$data['userLogin']]);
    if ($user === null) {
        return [
            'code' => -1,
            'message' => 'Ошибка авторизации, попробуйте еще раз'
        ];
    } else {
        if (password_verify($data['userPassword'], $user['password'])) {
            $_SESSION['logged_user'] = $user->export();
            unset($_SESSION['logged_user']['password']);
            return [
                'code' => 0
            ];
        } else {
            return [
                'code' => -1,
                'message' => 'Ошибка авторизации, попробуйте еще раз'
            ];
        }
    }
}


switch ($data['formAction']) {
    case "register":
        $response = createUser($data);
        break;
    case "login":
        $response = loginUser($data);
        break;
}

print_r(json_encode($response));