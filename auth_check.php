<?php
function auth_check($pdo)
{
    global $USER;
    //Проверка авторизован ли
    $auth = false;
    $user_id = null;

    if (isset($_COOKIE["secret_key"]) && isset($_COOKIE["user_id"])) {
        $secret_key = $_COOKIE["secret_key"];
        $user_id = $_COOKIE["user_id"];

        // Ищем сессию в базе данных
        $stmt = $pdo->prepare("SELECT * FROM auth_data WHERE user_id = ? AND secret_key = ? AND expires_at > NOW()");
        $stmt->execute([$user_id, $secret_key]);
        $auth_session = $stmt->fetch();

        // Если сессия найдена, значит, пользователь авторизован
        if ($auth_session) {
            $user_id = $_COOKIE["user_id"];
            $auth = true;
        }
    }

    $USER = ['auth' => $auth, 'user_id' => $user_id];
}