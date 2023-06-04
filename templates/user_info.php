<?php
require_once(__DIR__ . "/../database.php");

$stmt = $pdo->prepare("SELECT name, photo, birthday FROM users WHERE id = ?");
$stmt->execute([$USER['user_id']]);
$row = $stmt->fetch();
?>
<div class="info">
    <div class="user_info_container">
        <img class="user_avatar" src="uploads/<?= $row["photo"] ?>">
        <div class="user_data">
            <div class="user_data_item">
                <div class="prop_name">Name:</div>
                <div class="prop_value">
                    <?= $row["name"] ?>
                </div>
            </div>
            <div class="user_data_item">
                <div class="prop_name">Birthday:</div>
                <div class="prop_value">
                    <?= $row["birthday"] ?>
                </div>
            </div>
        </div>
    </div>
    <button id="logout" onclick="logout()">
        Log out
    </button>
</div>