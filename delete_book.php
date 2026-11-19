
<?php
require_once 'auth_check.php';
require_once 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: books.php");
exit;
?>
