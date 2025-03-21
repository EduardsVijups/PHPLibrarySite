<?php
function getAllBooks() {
    global $conn;
    return $conn->query("SELECT * FROM books");
}

function getTakenBooks($user_id) {
    global $conn;
    return $conn->query("SELECT * FROM books WHERE status='borrowed' AND userID=$user_id");
}
function getPendingBooks() {
    global $conn;
    return $conn->query("SELECT * FROM books WHERE status='pending'");
}
function handlePostRequests() {
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $conn->exec("INSERT INTO books (title, author, status) VALUES ('$title', '$author', 'available')");
    }
}
?>