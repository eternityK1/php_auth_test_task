<?php
require_once(__DIR__ . "/database.php");
require_once(__DIR__ . "/auth_check.php");

global $USER;
auth_check($pdo);
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
        //Вывожу шаблоны в зависимости от авторизации
        if ($USER['auth']) {
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