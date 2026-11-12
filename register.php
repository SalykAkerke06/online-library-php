<?php
require_once 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        $message = "Тіркелу сәтті аяқталды!";

    } else {
        $message = "Барлық өрісті толтырыңыз!";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Тіркелу</title>
</head>
<body>

<h2>Пайдаланушыны тіркеу</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Атыңыз" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Құпиясөз" required>
    <br><br>

    <button type="submit">Тіркелу</button>
</form>

<p><?php echo $message; ?></p>

</body>
</html>