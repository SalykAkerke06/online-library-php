

<?php
require_once 'auth_check.php';


$books = [
    [
        "title" => "Абай жолы",
        "author" => "Мұхтар Әуезов",
        "genre" => "Роман",
        "image" => "https://resources.cdn-kaspi.kz/img/m/p/h71/hbb/85276711583774.jpg?format=gallery-medium"
    ],
    [
        "title" => "Менің атым Қожа",
        "author" => "Бердібек Соқпақбаев",
        "genre" => "Повесть",
        "image" => "https://resources.cdn-kaspi.kz/img/m/p/p89/pfa/36101481.jpg?format=gallery-large"
    ],
    [
        "title" => "Көшпенділер",
        "author" => "Ілияс Есенберлин",
        "genre" => "Тарихи роман",
        
"image" => "https://kitapal.kz/media/7897/WhatsApp-Image-2021-02-17-at-14.13.49.png"

    ],
    [
        "title" => "Қан мен тер",
        "author" => "Әбдіжәміл Нұрпейісов",
        "genre" => "Роман",
        "image" => "https://shahtinsklib.kz/storage/books/YIpKevzxeJc1h2wQgXNPO4iu55k9utAz5eCi7dO1.jpg"
    ],
    [
        "title" => "Ұшқан ұя",
        "author" => "Бауыржан Момышұлы",
        "genre" => "Мемуар",
        "image" => "https://resources.cdn-kaspi.kz/img/m/p/pf6/p6b/68813417.jpg?format=gallery-large"
    ],
    [
        "title" => "Ақбілек",
        "author" => "Жүсіпбек Аймауытов",
        "genre" => "Роман",
        "image" => "https://static.insales-cdn.com/r/PqOMfz0eRFc/rs%3Afit%3A440%3A0%3A1/q%3A100/plain/images/products/1/6321/3152214193/large_Aimautov.png%40png"
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

<main class="catalog-page">

    <section class="catalog-hero">
        <span class="hero-label">БІЛІМГЕ БАСТАР ЖОЛ</span>
        <h2>Кітаптар каталогы</h2>
        <p>Өзіңізге ұнаған кітапты таңдаңыз және жаңа әлемге саяхат жасаңыз.</p>

        <form action="books.php" method="GET" class="book-search">
            <input
                type="text"
                name="search"
                placeholder="Кітап немесе автор іздеу..."
                value="<?php echo htmlspecialchars($search); ?>"
            >
            <button type="submit">⌕ Іздеу</button>
        </form>
    </section>

    <section class="catalog-content">

        <div class="catalog-heading">
            <div>
                <span>БІЗДІҢ ҚОР</span>
                <h2>Барлық кітаптар</h2>
            </div>

            <p>Табылған кітаптар: <?php echo count($filteredBooks); ?></p>
        </div>

        <div class="books catalog-grid">

            <?php if (count($filteredBooks) > 0): ?>

                <?php foreach ($filteredBooks as $book): ?>

                    <article class="book catalog-card">

                        <div class="book-image">
                            <img
                                src="<?php echo htmlspecialchars($book["image"]); ?>"
                                alt="<?php echo htmlspecialchars($book["title"]); ?>"
                            >

                            <span class="book-genre">
                                <?php echo htmlspecialchars($book["genre"]); ?>
                            </span>
                        </div>

                        <div class="book-info">

                            <h3>
                                <?php echo htmlspecialchars($book["title"]); ?>
                            </h3>

                            <p class="book-author">
                                Автор:
                                <?php echo htmlspecialchars($book["author"]); ?>
                            </p>

                            <div class="book-bottom">
                                <span>ONLINE LIBRARY</span>

                                <button type="button"
                                    onclick="alert('Кітап: <?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>')">
                                    Толығырақ →
                                </button>
                            </div>

                        </div>
                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty-books">
                    <span>📚</span>
                    <h3>Кітап табылмады</h3>
                    <p>Басқа атаумен немесе автор атымен іздеп көріңіз.</p>
                    <a href="books.php">Барлық кітаптарға оралу</a>
                </div>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>
