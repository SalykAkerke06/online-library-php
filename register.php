<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";

    // Аты-жөнін тексеру
    if ($name == "") {
        $message = "Аты-жөніңізді енгізіңіз!";
        $messageType = "error";
    }

    // Email тексеру
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email форматы дұрыс емес!";
        $messageType = "error";
    }

    // Телефонды тексеру
    elseif (!preg_match('/^\+7[0-9]{10}$/', $phone)) {
    $message = "Телефон нөмірін +7XXXXXXXXXX форматында енгізіңіз!";
    $messageType = "error";
}

    // Құпиясөзді тексеру
    elseif (strlen($password) < 8) {
        $message = "Құпиясөз кемінде 8 таңбадан тұруы керек!";
        $messageType = "error";
    }

    else {
        $message = "Тіркелу формасы сәтті тексерілді!";
        $messageType = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тіркелу | Онлайн кітапхана</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <main>
        <h2>Жаңа пайдаланушыны тіркеу</h2>

        <?php if ($message != ""): ?>
            <p class="<?php echo htmlspecialchars($messageType); ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form class="auth-form" action="register.php" method="POST">

            <label for="name">Аты-жөніңіз:</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Аты-жөніңізді енгізіңіз"
                required
            >

            <label for="email">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Email енгізіңіз"
                required
            >

            <label for="phone">Телефон нөмірі:</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                placeholder="+77771234567"
                pattern="\+7[0-9]{10}"
                title="Мысалы: +77771234567"
                required
            >

            <label for="password">Құпиясөз:</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Құпиясөз енгізіңіз"
                minlength="8"
                required
            >

            <button type="submit">Тіркелу</button>

        </form>

        <p>
            Аккаунтыңыз бар ма?
            <a href="login.php">Кіру</a>
        </p>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
