<?php
session_start();
include("config.php"); // Savienojums ar datubāzi
include("functions.php"); // Funkcijas
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
// Apstrādā POST pieprasījumus (piem., grāmatas pievienošana)
handlePostRequests();

// Iegūst grāmatu sarakstu
$books = getAllBooks();
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Bibliotēkas sistēma</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- Pievienot grāmatu -->
    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
        <h2>Pievienot Grāmatu</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Nosaukums" required>
            <input type="text" name="author" placeholder="Autors" required>
            <button type="submit" name="add_book">Pievienot</button>
        </form>
    <?php endif; ?>

    <h1>Grāmatu saraksts</h1>
    <?php
        $takenBooks = getTakenBooks($_SESSION['user']['id']);
    ?>

    <h2>Bibliotēka</h2>
    <ul>
        <?php while ($book = $books->fetchArray()): ?>
            <li><?= htmlspecialchars($book['title']) ?> - <?= htmlspecialchars($book['author']) ?>
            <?php if ($book['status'] == 'available'): ?>
                <p>(Pieejams)</p>
                <form method="POST" action="borrow.php">
                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                    <button type="submit">Aizņemt</button>
                </form>
            <?php elseif ($book['status'] == 'borrowed'): ?>
                <p>(Aizņemts līdz <?= $book['due_date'] ?>)</p>
            <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
    <h2>Tavas aizņemtās grāmatas</h2>
    <ul>
        <?php while ($takenBook = $takenBooks->fetchArray()): ?>
            <li><?= htmlspecialchars($takenBook['title']) ?> - <?= htmlspecialchars($takenBook['author']) ?> (Atgriezt līdz <?= $takenBook['due_date'] ?>)
                <?php if ($takenBook['status'] == 'borrowed' && $takenBook['userID'] == $_SESSION['user']['id']): ?>
                    <form method="POST" action="return.php">
                        <input type="hidden" name="book_id" value="<?= $takenBook['id'] ?>">
                        <button type="submit">Atgriezt</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="logout.php" style="margin-bottom: 5%">Log Out</a>
</body>
</html>