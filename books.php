
<?php
$books = [
    [
        "title" => "Абай жолы",
        "author" => "Мұхтар Әуезов",
        "genre" => "Роман"
    ],
    [
        "title" => "Менің атым Қожа",
        "author" => "Бердібек Соқпақбаев",
        "genre" => "Повесть"
    ],
    [
        "title" => "Көшпенділер",
        "author" => "Ілияс Есенберлин",
        "genre" => "Тарихи роман"
    ]
];

$search = trim($_GET["search"] ?? "");

$filteredBooks = [];

foreach ($books as $book) {
    if (
        $search == "" ||
        mb_stripos($book["title"], $search) !== false ||
        mb_stripos($book["author"], $search) !== false ||
        mb_stripos($book["genre"], $search) !== false
    ) {
        $filteredBooks[] = $book;
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кітаптар | Онлайн кітапхана</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include 'header.php'; ?>

<main>
    <h2>Кітаптар тізімі</h2>

    <form action="books.php" method="GET">
        <input
            type="text"
            name="search"
            placeholder="Кітапты іздеу..."
            value="<?php echo htmlspecialchars($search); ?>"
            style="padding: 12px; width: 280px; max-width: 85%;
            border-radius: 8px; border: 1px solid #ccc;"
        >

        <button type="submit">Іздеу</button>
    </form>

    <div class="books">

        <?php if (count($filteredBooks) > 0): ?>

            <?php foreach ($filteredBooks as $book): ?>

                <div class="book">
                    <h3>
                        <?php echo htmlspecialchars($book["title"]); ?>
                    </h3>

                    <p>
                        Автор:
                        <?php echo htmlspecialchars($book["author"]); ?>
                    </p>

                    <p>
                        Жанр:
                        <?php echo htmlspecialchars($book["genre"]); ?>
                    </p>

                    <button type="button">Толығырақ</button>
                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p>Іздеу бойынша кітап табылмады.</p>

        <?php endif; ?>

    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
