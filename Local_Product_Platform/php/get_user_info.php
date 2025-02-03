<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    echo json_encode([
        'isLoggedIn' => true,
        'userName' => $_SESSION['user_name']
    ]);
} else {
    echo json_encode([
        'isLoggedIn' => false
    ]);
}
?>
