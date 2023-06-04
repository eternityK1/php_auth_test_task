<?php
require_once(__DIR__ . "/../database.php");
require_once(__DIR__ . "/../auth_check.php");

global $USER;
auth_check($pdo);

//Вывожу шаблон
if ($USER['auth']) {
    require(__DIR__ . "/../templates/user_info.php");
} else {
    echo "error";
}