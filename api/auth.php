<?php
require_once(__DIR__ . "/../database.php");

//Защита от брутфорса
//Чистим таблицу, чтобы не скопилось много записей по IP
$ip_address = $_SERVER["REMOTE_ADDR"];
$stmt = $pdo->prepare("SELECT id FROM login_attempts WHERE ip_address = ? ORDER BY attempt_time DESC LIMIT 50, 1");
$stmt->execute([$ip_address]);
$row = $stmt->fetch();

if ($row) {
    $last_id = $row["id"];

    $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE ip_address = ? AND id <= ?");
    $stmt->execute([$ip_address, $last_id]);
}

//Проверим, сколько попыток пароля было совершено
$attempt_time = date("Y-m-d H:i:s", strtotime("-5 minutes"));

$stmt = $pdo->prepare("SELECT COUNT(*) AS attempts FROM login_attempts WHERE ip_address = ? AND attempt_time > ?");
$stmt->execute([$ip_address, $attempt_time]);
$row = $stmt->fetch();

$attempts = $row["attempts"];

//Если попыток слишком много отклоняем запрос
if ($attempts > 5) {
    echo json_encode(["auth" => false, "error" => "limit"]);
    exit();
}

session_start();

//Если пришёл логин пароль, то авторизуем
if (isset($_POST["username"]) && isset($_POST["password"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {

        // Генерируем случайную строку
        $key = bin2hex(random_bytes(20));

        // Устанавливаем переменные сессии
        $_SESSION["key"] = $key;
        $_SESSION["user_id"] = $user["id"];

        // Устанавливаем cookies
        setcookie("key", $key, time() + (86400 * 30), "/");
        setcookie("user_id", $user["id"], time() + (86400 * 30), "/");

        $auth = true;


        // Выводим сообщение об успешной авторизации
        echo json_encode(["auth" => true, "user_id" => $user["id"]]);

    } else {
        //Записываем данные в бд о запросах авторизации
        $attempt_time = date("Y-m-d H:i:s");

        $stmt = $pdo->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, ?)");
        $stmt->execute([$ip_address, $attempt_time]);

        echo json_encode(["auth" => false, "error" => "password"]);
    }

}