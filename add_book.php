
<?php
require_once 'auth_check.php';
require_once 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"] ?? "");
    $author = trim($_POST["author"] ?? "");
    $genre = trim($_POST["genre"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($title == "" || $author == "" || $genre == "") {
        $error = "Міндетті өрістерді толтырыңыз!";
    } else {

        $stmt = $pdo->prepare(
            "INSERT INTO books (title, author, genre, description)
             VALUES (:title, :author, :genre, :description)"
        );

        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':description' => $description
        ]);

        header("Location: books.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Кітап қосу</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include 'header.php'; ?>

<main class="catalog-page">

    <h2>Жаңа кітап қосу</h2>

    <?php if ($error != ""): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Кітап атауы:</label>
        <input type="text" name="title" required>

        <br><br>

        <label>Автор:</label>
        <input type="text" name="author" required>

        <br><br>

        <label>Жанры:</label>
        <input type="text" name="genre" required>

        <br><br>

        <label>Сипаттамасы:</label>
        <textarea name="description"></textarea>

        <br><br>

        <button type="submit">Кітапты сақтау</button>

    </form>

    <br>
    <a href="books.php">Кітаптарға оралу</a>

</main>

<?php include 'footer.php'; ?>

</body>
</html>
