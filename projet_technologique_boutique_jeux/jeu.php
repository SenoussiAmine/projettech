<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM jeu WHERE id = ?");
$stmt->execute([$id]);
$jeu = $stmt->fetch();

if (!$jeu) {
    echo "Jeu introuvable.";
    exit;
}

$image = $jeu['image'] ? 'uploads/' . htmlspecialchars($jeu['image']) : 'uploads/default.png';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($jeu['nom']) ?> – Détails</title>
    <link rel="icon" href="uploads/logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
        }

        .image-container {
            flex: 1 1 40%;
            background: #fafafa;
            padding: 20px;
            text-align: center;
        }

        .image-container img {
            max-width: 100%;
            border-radius: 8px;
        }

        .details {
            flex: 1 1 60%;
            padding: 30px;
        }

        .details h1 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .details p {
            margin: 8px 0;
            color: #555;
        }

        .details strong {
            color: #2c3e50;
        }

        .section-title {
            margin-top: 25px;
            font-weight: 600;
            font-size: 18px;
            color: #34495e;
        }

        .back-button {
            display: inline-block;
            margin: 25px auto;
            text-align: center;
            background: #3498db;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }

        .back-button:hover {
            background: #2980b9;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .image-container,
            .details {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="image-container">
        <img src="<?= $image ?>" alt="<?= htmlspecialchars($jeu['nom']) ?>">
    </div>

    <div class="details">
        <h1><?= htmlspecialchars($jeu['nom']) ?></h1>
        <p><strong>Type :</strong> <?= htmlspecialchars($jeu['type']) ?></p>
        <p><strong>Genre :</strong> <?= htmlspecialchars($jeu['genre']) ?></p>
        <p><strong>Année de sortie :</strong> <?= htmlspecialchars($jeu['annee_sortie']) ?></p>

        <?php if (!empty($jeu['description_courte'])): ?>
            <p class="section-title">📝 Description courte</p>
            <p><?= htmlspecialchars($jeu['description_courte']) ?></p>
        <?php endif; ?>

        <?php if (!empty($jeu['description_longue'])): ?>
            <p class="section-title">📖 Description longue</p>
            <p><?= nl2br(htmlspecialchars($jeu['description_longue'])) ?></p>
        <?php endif; ?>
    </div>
</div>

<div style="text-align: center;">
    <a href="index.php" class="back-button">← Retour à la liste</a>
</div>

</body>
</html>
