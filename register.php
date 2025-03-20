<?php
session_start();
include("config.php");

// Apstrādā reģistrāciju
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Drošā paroļu hashēšana

    // Pārbauda, vai e-pasts jau eksistē
    $check = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $check->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $check->execute()->fetchArray();

    if ($result) {
        echo "Šis e-pasts jau ir reģistrēts!";
    } else {
        // Pievieno lietotāju
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':password', $password, SQLITE3_TEXT);
        $stmt->execute();
        echo "Reģistrācija veiksmīga! <a href='login.php'>Pieslēgties</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Reģistrācija</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Reģistrācija</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="E-pasts" required>
        <input type="password" name="password" placeholder="Parole" required>
        <p></p>
        <button type="submit" name="register">Reģistrēties</button>
    </form>
    <p>Jau esi reģistrējies? <a href="login.php">Pieslēgties</a></p>
</body>
</html>