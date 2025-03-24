<?php
include("../../config/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['user']['id'];
    $conn->exec("UPDATE books SET status='borrowed', userID=$user_id, due_date=DATE('now', '+14 days') WHERE id=$book_id AND status='available'");
}

header("Location: ../../index.php");
exit();
?>