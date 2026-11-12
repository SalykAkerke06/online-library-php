
<?php
require_once 'auth_check.php';
require_once 'db.php';

$search = trim($_GET['search'] ?? '');

$sql = "SELECT id, username FROM users";

if ($search !== '') {
    $sql .= " WHERE username LIKE :search";
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);

if ($search !== '') {
    $stmt->execute([':search' => "%$search%"]);
} else {
    $stmt->execute();
}

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalStudents = count($students);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Студенттер | Онлайн кітапхана</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include 'header.php'; ?>

<main class="students-page">

    <section class="students-hero">
        <span class="student-label">ONLINE LIBRARY COMMUNITY</span>

        <h2>Студенттер әлеміне қош келдіңіз!</h2>

        <p>
            Білімге ұмтылған оқырмандар қауымдастығына қосылыңыз.
            Кітап оқыңыз, ізденіңіз және дамыңыз.
        </p>

        <form action="id_student.php" method="GET" class="student-search">
            <input
                type="text"
                name="search"
                placeholder="Студенттің атын іздеу..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">Іздеу</button>
        </form>
    </section>

    <section class="student-content">

        <div class="student-heading">
            <div>
                <span>БІЗДІҢ ҚАУЫМДАСТЫҚ</span>
                <h2>Тіркелген оқырмандар</h2>
            </div>

            <div class="student-count">
                <strong><?php echo $totalStudents; ?></strong>
                <span>Пайдаланушы</span>
            </div>
        </div>

        <div class="student-grid">

            <?php if ($totalStudents > 0): ?>

                <?php foreach ($students as $student): ?>

                    <?php
                    $name = $student['username'];
                    $initial = mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8');
                    ?>

                    <article class="student-card">

                        <div class="student-avatar">
                            <?php echo htmlspecialchars($initial); ?>
                        </div>

                        <div class="student-info">
                            <span class="student-status">ТІРКЕЛГЕН ОҚЫРМАН</span>

                            <h3>
                                <?php echo htmlspecialchars($name); ?>
                            </h3>

                            <p>Онлайн кітапхана мүшесі</p>
                        </div>

                        <div class="student-card-bottom">
                            <span>ONLINE LIBRARY</span>
                            <span>№ <?php echo (int)$student['id']; ?></span>
                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="student-empty">
                    <span>📚</span>
                    <h3>Оқырмандар әзірге табылмады</h3>
                    <p>Басқа атпен іздеп көріңіз немесе тіркеліңіз.</p>
                </div>

            <?php endif; ?>

        </div>

    </section>

    <section class="student-benefits">

        <div>
            <span>01</span>
            <h3>Білім алу</h3>
            <p>Әртүрлі жанрдағы кітаптармен біліміңізді кеңейтіңіз.</p>
        </div>

        <div>
            <span>02</span>
            <h3>Ізденіс</h3>
            <p>Өзіңізге қажетті кітаптарды оңай тауып оқыңыз.</p>
        </div>

        <div>
            <span>03</span>
            <h3>Даму</h3>
            <p>Күнделікті оқу арқылы жаңа ақпарат алыңыз.</p>
        </div>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>
