
<?php
require_once 'auth_check.php';
require_once 'db.php';

// Іздеу және сүзгі параметрлері
$search = trim($_GET["search"] ?? "");
$genreFilter = trim($_GET["genre"] ?? "");
$dateFrom = trim($_GET["date_from"] ?? "");
$dateTo = trim($_GET["date_to"] ?? "");
$sort = $_GET["sort"] ?? "newest";

// Жанрларды деректер базасынан алу
$genres = $pdo->query(
    "SELECT DISTINCT genre FROM books
     WHERE genre IS NOT NULL AND genre != ''
     ORDER BY genre ASC"
)->fetchAll(PDO::FETCH_COLUMN);

// Сұрыптау
$orderBy = "created_at DESC";

if ($sort === "oldest") {
    $orderBy = "created_at ASC";
} elseif ($sort === "title") {
    $orderBy = "title ASC";
}

// SQL сүзгілері
$where = [];
$params = [];

// Кітап атауы, авторы, жанры бойынша іздеу
if ($search !== "") {
    $where[] = "(title LIKE :search_title
                 OR author LIKE :search_author
                 OR genre LIKE :search_genre)";

    $params[":search_title"] = "%" . $search . "%";
    $params[":search_author"] = "%" . $search . "%";
    $params[":search_genre"] = "%" . $search . "%";
}

// Жанр бойынша сүзгі
if ($genreFilter !== "" && in_array($genreFilter, $genres, true)) {
    $where[] = "genre = :genre";
    $params[":genre"] = $genreFilter;
}

// Бастапқы күн
if ($dateFrom !== "" && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom)) {
    $where[] = "DATE(created_at) >= :date_from";
    $params[":date_from"] = $dateFrom;
}

// Соңғы күн
if ($dateTo !== "" && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)) {
    $where[] = "DATE(created_at) <= :date_to";
    $params[":date_to"] = $dateTo;
}

// WHERE бөлігін құрастыру
$whereSQL = "";

if (count($where) > 0) {
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

// Барлық кітап санын есептеу
$countSQL = "SELECT COUNT(*) FROM books $whereSQL";

$countStmt = $pdo->prepare($countSQL);
$countStmt->execute($params);

$totalBooks = (int) $countStmt->fetchColumn();

// Пагинация
$booksPerPage = 6;
$totalPages = max(1, ceil($totalBooks / $booksPerPage));

$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $booksPerPage;

// Кітаптарды алу
$sql = "SELECT * FROM books
        $whereSQL
        ORDER BY $orderBy
        LIMIT $booksPerPage OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$filteredBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Кітап суреттері
$images = [
    "Абай жолы" => "https://resources.cdn-kaspi.kz/img/m/p/h71/hbb/85276711583774.jpg?format=gallery-medium",
    "Менің атым Қожа" => "https://resources.cdn-kaspi.kz/img/m/p/p89/pfa/36101481.jpg?format=gallery-large",
    "Көшпенділер" => "https://kitapal.kz/media/7897/WhatsApp-Image-2021-02-17-at-14.13.49.png",
    "Қан мен тер" => "https://shahtinsklib.kz/storage/books/YIpKevzxeJc1h2wQgXNPO4iu55k9utAz5eCi7dO1.jpg",
    "Ұшқан ұя" => "https://resources.cdn-kaspi.kz/img/m/p/pf6/p6b/68813417.jpg?format=gallery-large",
    "Ақбілек" => "https://static.insales-cdn.com/r/PqOMfz0eRFc/rs%3Afit%3A440%3A0%3A1/q%3A100/plain/images/products/1/6321/3152214193/large_Aimautov.png%40png",
     "Шығыс экспресіндегі кісі өлтіру" =>
        "https://comicvine.gamespot.com/a/uploads/scale_medium/11116/111168846/9587326-7933296826-mord-.jpg",

    "Гарри Поттер және философиялық тас" =>
        "https://images-na.ssl-images-amazon.com/images/I/81m1s4wIPML.jpg",

    "Джейн Эйр" =>
        "https://avatars.mds.yandex.net/i?id=92b37c63d6c88f5f9e1479c2d7d2c61d_l-8449287-images-thumbs&n=13",

    "Кішкентай ханзада" =>
        "https://content.img-gorod.ru/pim/products/images/56/a2/019e6a09-89b4-7cfc-8e16-f4dd7c5056a2.jpg",

    "Үш нөкер" =>
        "https://avatars.mds.yandex.net/i?id=4d6fd45eb5da04b9cf578162f9ecf65f_l-12749638-images-thumbs&n=13",

    "Жас қыздың күнделігі" =>
        "https://images-na.ssl-images-amazon.com/images/I/81eB+7+CkUL.jpg"
];

// Пагинация сілтемелеріне параметрлер
$queryParams = [
    "search" => $search,
    "genre" => $genreFilter,
    "date_from" => $dateFrom,
    "date_to" => $dateTo,
    "sort" => $sort
];
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

            <p>Табылған кітаптар: <?php echo $totalBooks; ?></p>
        </div>

        <!-- Кітап қосу -->
        <div style="margin-bottom:25px;">
            <a href="add_book.php"
               style="display:inline-block;background:#23634f;color:white;padding:14px 22px;border-radius:10px;text-decoration:none;font-weight:bold;">
                + Жаңа кітап қосу
            </a>
        </div>

        <!-- Сүзгі және сұрыптау -->
        <form action="books.php" method="GET"
              style="display:flex;gap:15px;flex-wrap:wrap;align-items:end;margin-bottom:30px;background:#f5f5f5;padding:20px;border-radius:12px;">

            <input type="hidden" name="search"
                   value="<?php echo htmlspecialchars($search); ?>">

            <div>
                <label for="genre">Жанр:</label><br>
                <select name="genre" id="genre"
                        style="padding:10px;border-radius:8px;">
                    <option value="">Барлық жанр</option>

                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo htmlspecialchars($genre); ?>"
                            <?php if ($genreFilter === $genre) echo "selected"; ?>>
                            <?php echo htmlspecialchars($genre); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="date_from">Бастапқы күн:</label><br>
                <input type="date" name="date_from" id="date_from"
                       value="<?php echo htmlspecialchars($dateFrom); ?>"
                       style="padding:10px;border-radius:8px;">
            </div>

            <div>
                <label for="date_to">Соңғы күн:</label><br>
                <input type="date" name="date_to" id="date_to"
                       value="<?php echo htmlspecialchars($dateTo); ?>"
                       style="padding:10px;border-radius:8px;">
            </div>

            <div>
                <label for="sort">Сұрыптау:</label><br>
                <select name="sort" id="sort"
                        style="padding:10px;border-radius:8px;">
                    <option value="newest" <?php if ($sort === "newest") echo "selected"; ?>>
                        Жаңадан қосылған
                    </option>

                    <option value="oldest" <?php if ($sort === "oldest") echo "selected"; ?>>
                        Ескі кітаптар
                    </option>

                    <option value="title" <?php if ($sort === "title") echo "selected"; ?>>
                        Атауы бойынша
                    </option>
                </select>
            </div>

            <button type="submit"
                    style="background:#23634f;color:white;padding:11px 20px;border:0;border-radius:8px;cursor:pointer;">
                Сүзу
            </button>

            <a href="books.php"
               style="padding:11px 15px;color:#23634f;text-decoration:none;">
                Тазалау
            </a>

        </form>

        <!-- Кітаптар -->
        <div class="books catalog-grid">

            <?php if (count($filteredBooks) > 0): ?>

                <?php foreach ($filteredBooks as $book): ?>

                    <?php $image = $images[$book["title"]] ?? ""; ?>

                    <article class="book catalog-card">

                        <div class="book-image">

                            <?php if ($image !== ""): ?>
                                <img
                                    src="<?php echo htmlspecialchars($image); ?>"
                                    alt="<?php echo htmlspecialchars($book["title"]); ?>"
                                >
                            <?php endif; ?>

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

                            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:15px;">

                                <a href="edit_book.php?id=<?php echo (int)$book['id']; ?>"
                                   style="background:#d99b42;color:white;padding:10px 15px;border-radius:8px;text-decoration:none;">
                                    ✏ Өзгерту
                                </a>

                                <a href="delete_book.php?id=<?php echo (int)$book['id']; ?>"
                                   onclick="return confirm('Бұл кітапты өшіргіңіз келе ме?')"
                                   style="background:#b94b4b;color:white;padding:10px 15px;border-radius:8px;text-decoration:none;">
                                    🗑 Өшіру
                                </a>

                            </div>

                        </div>
                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty-books">
                    <span>📚</span>
                    <h3>Кітап табылмады</h3>
                    <p>Іздеу немесе сүзгі параметрлерін өзгертіп көріңіз.</p>
                    <a href="books.php">Барлық кітаптарға оралу</a>
                </div>

            <?php endif; ?>

        </div>

        <!-- Пагинация -->
        <?php if ($totalPages > 1): ?>

            <div style="display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin-top:35px;">

                <?php if ($page > 1): ?>
                    <?php
                    $queryParams["page"] = $page - 1;
                    ?>
                    <a href="books.php?<?php echo http_build_query($queryParams); ?>"
                       style="padding:10px 15px;background:#23634f;color:white;border-radius:8px;text-decoration:none;">
                        ← Алдыңғы
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                    <?php
                    $queryParams["page"] = $i;
                    ?>

                    <a href="books.php?<?php echo http_build_query($queryParams); ?>"
                       style="padding:10px 15px;background:<?php echo $page === $i ? '#d99b42' : '#eeeeee'; ?>;color:#222;border-radius:8px;text-decoration:none;">
                        <?php echo $i; ?>
                    </a>

                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <?php
                    $queryParams["page"] = $page + 1;
                    ?>
                    <a href="books.php?<?php echo http_build_query($queryParams); ?>"
                       style="padding:10px 15px;background:#23634f;color:white;border-radius:8px;text-decoration:none;">
                        Келесі →
                    </a>
                <?php endif; ?>

            </div>

        <?php endif; ?>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>
