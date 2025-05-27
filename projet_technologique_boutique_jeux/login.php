<?php
session_start();

// Identifiants admin
$utilisateur_correct = 'admin';
$motdepasse_correct = 'admin123';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $utilisateur_correct && $password === $motdepasse_correct) {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    } else {
        $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            background: #2980b9; color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>🔐 Connexion Admin</h2>

    <?php if ($erreur): ?>
        <div class="error"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required>

        <label>Mot de passe :</label>
        <input type="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>
