<?php
include("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $conn->exec("UPDATE books SET status='pending', due_date=NULL WHERE id=$book_id");
}

header("Location: index.php");
exit();
?>