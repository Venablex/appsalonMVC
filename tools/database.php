<?php 

function connectDB():mysqli {
    $db = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['DB_NAME']
    );

    $db->set_charset('utf8mb4');

    if (!$db) {
        exit;
    }
    return $db;
}

?>