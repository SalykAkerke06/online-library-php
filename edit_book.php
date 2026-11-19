
<?php
require_once 'auth_check.php';
require_once 'db.php';

$error = "";

// Кітап ID нөмірін тексеру
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Кітап табылмады!");
}

$id = (int) $_GET['id'];

// Кітапты деректер қорынан алу
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
$stmt->execute([':id' => $id]);

$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Кітап табылмады!");
}

// Өзгерістерді сақтау
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"] ?? "");
    $author = trim($_POST["author"] ?? "");
    $genre = trim($_POST["genre"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($title == "" || $author == "" || $genre == "") {
        $error = "Міндетті өрістерді толтырыңыз!";
    } else {

        $stmt = $pdo->prepare(
            "UPDATE books
             SET title = :title,
                 author = :author,
                 genre = :genre,
                 description = :description
             WHERE id = :id"
        );

        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':description' => $description,
            ':id' => $id
        ]);

        header("Location: books.php");
        exit;
    }

    $book['title'] = $title;
    $book['author'] = $author;
    $book['genre'] = $genre;
    $book['description'] = $description;
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кітапты өзгерту</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include 'header.php'; ?>

<main class="catalog-page">

    <h2>Кітапты өзгерту</h2>

    <?php if ($error != ""): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Кітап атауы:</label>
        <input type="text" name="title"
            value="<?php echo htmlspecialchars($book['title']); ?>"
            required>

        <br><br>

        <label>Автор:</label>
        <input type="text" name="author"
            value="<?php echo htmlspecialchars($book['author']); ?>"
            required>

        <br><br>

        <label>Жанры:</label>
        <input type="text" name="genre"
            value="<?php echo htmlspecialchars($book['genre']); ?>"
            required>

        <br><br>

        <label>Сипаттамасы:</label>
        <textarea name="description"><?php echo htmlspecialchars($book['description']); ?></textarea>

        <br><br>

        <button type="submit">Өзгерістерді сақтау</button>

    </form>

    <br>

    <a href="books.php">Кітаптарға оралу</a>

</main>

<?php include 'footer.php'; ?>

</body>
</html>
