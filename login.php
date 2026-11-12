
<?php
session_start();
require_once 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: index.php");
        exit();

    } else {
        $message = "Email немесе құпиясөз қате!";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Кіру</title>
</head>
<body>

<h2>Жүйеге кіру</h2>

<form method="POST">

    <input type="email" name="email"
    placeholder="Email" required>

    <br><br>

    <input type="password" name="password"
    placeholder="Құпиясөз" required>

    <br><br>

    <button type="submit">Кіру</button>

</form>

<p><?php echo $message; ?></p>

</body>
</html>