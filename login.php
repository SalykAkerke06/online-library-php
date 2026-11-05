
<?php
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Email тексеру
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email форматы дұрыс емес!";
        $messageType = "error";
    }

    // Құпиясөзді тексеру
    elseif ($password == "") {
        $message = "Құпиясөзді енгізіңіз!";
        $messageType = "error";
    }

    else {
        $message = "Мәліметтер қабылданды! Кіруді тексеру үшін дерекқор қажет.";
        $messageType = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кіру | Онлайн кітапхана</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <main>
        <h2>Жүйеге кіру</h2>

        <?php if ($message != ""): ?>
            <p class="<?php echo htmlspecialchars($messageType); ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form class="auth-form" id="loginForm"
              action="login.php" method="POST">

            <label for="email">Email:</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Email енгізіңіз"
                required
            >

            <label for="password">Құпиясөз:</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Құпиясөз енгізіңіз"
                required
            >

            <button type="submit">Кіру</button>

        </form>

        <p>
            Аккаунтыңыз жоқ па?
            <a href="register.php">Тіркелу</a>
        </p>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>

