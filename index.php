<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>AEON test work</title>
    <script src="script.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rubik" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container" id="content">
        <?php
        //Проверка авторизован ли
        $auth = false;
        $user_id = null;

        if (isset($_COOKIE["key"]) && isset($_COOKIE["user_id"])) {
            if ($_SESSION["key"] == $_COOKIE["key"] && $_SESSION["user_id"] == $_COOKIE["user_id"]) {
                $user_id = $_COOKIE["user_id"];
                $auth = true;
            }
        }

        //Вывожу шаблоны в зависимости от авторизации
        if ($auth && !is_null($user_id)) {
            require(__DIR__ . "/templates/user_info.php");
        } else {
            require(__DIR__ . "/templates/auth.php");
        }
        ?>
    </div>

    <div class="notification" id="notification">
        <div class="message">Successful authorization</div>
        <div class="spinner"></div>
    </div>
</body>

</html>