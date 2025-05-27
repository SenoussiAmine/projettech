<?php
require_once 'config.php';

// Récupération des événements à venir
$evenements = $pdo->query("SELECT * FROM evenement WHERE date >= CURDATE() ORDER BY date ASC")->fetchAll();

// Récupère l’ID de l’événement sélectionné s’il est passé dans l’URL
$evenement_id_selectionne = isset($_GET['evenement_id']) ? intval($_GET['evenement_id']) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription à un événement</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        .form-container {
            background: white; max-width: 600px; margin: auto;
            padding: 30px; border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 { font-size: 24px; margin-bottom: 20px; }
        label { display: block; margin: 10px 0 5px; }
        input, select {
            width: 100%; padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #2c3e50; color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background: #1a242f;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>📝 Inscription à un événement</h1>
    <form action="evenement_inscription_traitement.php" method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" required>

        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Nombre d'accompagnants :</label>
        <input type="number" name="accompagnants" min="0" value="0">

        <label>Choix de l'événement :</label>
        <select name="evenement_id" required>
            <option value="">-- Sélectionnez un événement --</option>
            <?php foreach ($evenements as $evt): ?>
                <?php
                $selected = ($evt['id'] == $evenement_id_selectionne) ? 'selected' : '';
                ?>
                <option value="<?= $evt['id'] ?>" <?= $selected ?>>
                    <?= htmlspecialchars($evt['titre']) ?> – <?= $evt['date'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">S'inscrire</button>
    </form>
</div>

</body>
</html>
