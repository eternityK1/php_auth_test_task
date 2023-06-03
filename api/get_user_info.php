<?php
session_start();

//Проверка авторизован ли
$auth = false;
$user_id = null;

if (isset($_COOKIE["key"]) && isset($_COOKIE["user_id"])) {
    if ($_SESSION["key"] == $_COOKIE["key"] && $_SESSION["user_id"] == $_COOKIE["user_id"]) {
        $user_id = $_COOKIE["user_id"];
        $auth = true;
    }
}

//Вывожу шаблон
if ($auth && !is_null($user_id)) {
    require(__DIR__ . "/../templates/user_info.php");
} else {
    echo "error";
}