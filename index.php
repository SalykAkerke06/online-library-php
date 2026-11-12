
<?php
$pageTitle = "Онлайн кітапхана";
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Басты баннер -->
<section class="hero">
    <div class="hero-content">
        <span class="hero-label">ONLINE LIBRARY</span>

        <h2>Кітаптар әлеміне<br>қош келдіңіз!</h2>

        <p>
            Жаңа білімге жол ашыңыз.
            Өзіңізге ұнаған кітапты таңдап,
            оқу әлеміне саяхат жасаңыз.
        </p>

        <a href="books.php" class="hero-button">
            Кітаптарды қарау →
        </a>
    </div>

    <div class="hero-image">
        <img
        src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1000"
        alt="Әдемі кітапхана">
    </div>
</section>

<!-- Артықшылықтар -->
<section class="features">
    <div class="feature">
        <span>📚</span>
        <h3>Үлкен кітап қоры</h3>
        <p>Әртүрлі тақырыптағы кітаптар.</p>
    </div>

    <div class="feature">
        <span>🔎</span>
        <h3>Оңай іздеу</h3>
        <p>Қажетті кітапты жылдам табыңыз.</p>
    </div>

    <div class="feature">
        <span>💻</span>
        <h3>Онлайн қолжетімділік</h3>
        <p>Кітапханаға кез келген уақытта кіріңіз.</p>
    </div>
</section>

<!-- Танымал кітаптар -->
<section class="popular">
    <div class="section-heading">
        <span>БІЗДІҢ КІТАПХАНА</span>
        <h2>Танымал кітаптар</h2>
        <p>Оқырмандар таңдаған кітаптар</p>
    </div>

    <div class="popular-books">

        <div class="popular-card">
            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500"
            alt="Кітап мұқабасы">
            <h3>Кітаптар әлемі</h3>
            <p>Көркем әдебиет</p>
        </div>

        <div class="popular-card">
            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500"
            alt="Кітаптар">
            <h3>Білім бұлағы</h3>
            <p>Білім және ғылым</p>
        </div>

        <div class="popular-card">
            <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500"
            alt="Ашық кітап">
            <h3>Жаңа мүмкіндіктер</h3>
            <p>Танымдық әдебиет</p>
        </div>

    </div>

    <a href="books.php" class="all-books">
        Барлық кітаптарды көру →
    </a>
</section>

<!-- Кітапхана туралы -->
<section class="about">
    <span>БІЗ ТУРАЛЫ</span>
    <h2>Біздің кітапхана</h2>

    <p>
        Онлайн кітапхана – оқырмандарға қажетті
        кітаптарды іздеуге, таңдауға және білімін
        жетілдіруге арналған цифрлық платформа.
    </p>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
