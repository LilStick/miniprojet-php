<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $message]);
        // Rediriger après l'insertion pour éviter la soumission multiple
        header('Location: index.php'); 
        exit();
    }
}

// Récupérer les messages
$messages = $pdo->query("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Livre d'or</title>
</head>
<body>
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <form method="POST" action="">
        <label>Votre message:</label>
        <textarea name="message" required></textarea>
        <br>
        <button type="submit">Envoyer</button>
    </form>

    <h3>Messages:</h3>
    <?php foreach ($messages as $msg): ?>
        <p>
            <strong><?php echo htmlspecialchars($msg['username']); ?></strong> 
            (<?php echo $msg['created_at']; ?>):
            <br>
            <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
        </p>
    <?php endforeach; ?>

    <a href="logout.php">Déconnexion</a>
</body>
</html> 