<?php
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['user'] = $result;
        header("Location: index.php"); // Novirza uz galveno lapu
        exit();
    } else {
        echo "⚠️ Nepareizs e-pasts vai parole!";
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Pieslēgšanās</title>
</head>
<body>
    <h2>Pieslēgšanās</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="E-pasts" required>
        <input type="password" name="password" placeholder="Parole" required>
        <button type="submit" name="login">Pieslēgties</button>
    </form>
    <p>Nav konta? <a href="register.php">Reģistrēties</a></p>
</body>
</html>