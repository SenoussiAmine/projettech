<?php
session_start();
require_once 'config.php';

// 🔍 Recherche et filtres
$search = $_GET['search'] ?? '';
$filtre_type = $_GET['type'] ?? '';
$filtre_genre = $_GET['genre'] ?? '';

// 🔽 Valeurs pour les filtres
$types = $pdo->query("SELECT DISTINCT type FROM jeu ORDER BY type")->fetchAll();
$genres = $pdo->query("SELECT DISTINCT genre FROM jeu ORDER BY genre")->fetchAll();

// 📦 Requête jeux
$sql = "SELECT * FROM jeu WHERE 1=1";
$params = [];

if ($filtre_type) {
    $sql .= " AND type = ?";
    $params[] = $filtre_type;
}
if ($filtre_genre) {
    $sql .= " AND genre = ?";
    $params[] = $filtre_genre;
}
if ($search) {
    $sql .= " AND nom LIKE ?";
    $params[] = "%$search%";
}

$sql .= " ORDER BY id DESC LIMIT 20";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$jeux = $stmt->fetchAll();

// 📅 Prochains événements
$evenements = $pdo->query("SELECT * FROM evenement WHERE date >= CURDATE() ORDER BY date ASC LIMIT 5")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil – Ludothèque</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            color: #2c3e50;
        }

        header {
            background: #34495e;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .header-top img {
            height: 50px;
        }

        .header-top span {
            font-size: 30px;
            font-weight: 600;
        }

        header a {
            color: white;
            font-size: 15px;
            text-decoration: underline;
            margin-top: 4px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }

        form.filtres {
            margin-bottom: 25px;
        }

        input[type="text"], select {
            padding: 8px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-content h3 {
            font-size: 18px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .card-content p {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .btn {
            background: #2ecc71;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            padding: 8px 12px;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn:hover {
            background: #27ae60;
        }

        footer {
            background: #ecf0f1;
            text-align: center;
            padding: 30px 0;
            color: #555;
            font-size: 13px;
        }

        footer a {
            color: #2c3e50;
            text-decoration: underline;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<header>
    <div class="header-content">
        <div class="header-top">
            <img src="uploads/logo.png" alt="Logo Ludothèque">
            <span>Bienvenue dans la Ludothèque</span>
        </div>
        <a href="evenements.php">📅 Voir tous les événements</a>
        <?php if (isset($_SESSION['admin'])): ?>
            <a href="logout.php">🔓 Se déconnecter</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">

    <h2>🕹️ Nos Jeux Récents</h2>

    <form method="GET" class="filtres">
        <input type="text" name="search" placeholder="Rechercher un jeu..." value="<?= htmlspecialchars($search) ?>">
        <select name="type">
            <option value="">-- Tous les types --</option>
            <?php foreach ($types as $t): ?>
                <option value="<?= $t['type'] ?>" <?= ($filtre_type == $t['type']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['type']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="genre">
            <option value="">-- Tous les genres --</option>
            <?php foreach ($genres as $g): ?>
                <option value="<?= $g['genre'] ?>" <?= ($filtre_genre == $g['genre']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($g['genre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <div class="grid">
        <?php foreach ($jeux as $jeu): ?>
            <div class="card">
                <?php
                $image = $jeu['image'] ? 'uploads/' . htmlspecialchars($jeu['image']) : 'uploads/default.png';
                ?>
                <img src="<?= $image ?>" alt="<?= htmlspecialchars($jeu['nom']) ?>">
                <div class="card-content">
                    <h3><?= htmlspecialchars($jeu['nom']) ?></h3>
                    <p><strong>Type :</strong> <?= htmlspecialchars($jeu['type']) ?></p>
                    <p><strong>Genre :</strong> <?= htmlspecialchars($jeu['genre']) ?></p>
                    <a href="jeu.php?id=<?= $jeu['id'] ?>" class="btn">Voir plus</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>📅 Prochains Événements</h2>
    <div class="grid">
        <?php foreach ($evenements as $event): ?>
            <div class="card">
                <div class="card-content">
                    <h3><?= htmlspecialchars($event['titre']) ?></h3>
                    <p><strong>Date :</strong> <?= htmlspecialchars($event['date']) ?></p>
                    <p><strong>Durée :</strong> <?= htmlspecialchars($event['duree']) ?> h</p>
                    <p><strong>Capacité :</strong> <?= htmlspecialchars($event['capacite']) ?> participants</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<footer>
    © <?= date('Y') ?> Ludothèque – Projet technologique développé avec passion 🎮
    <br>
    <a href="evenements.php">📅 Tous les événements</a> |
    <a href="index.php">🕹️ Tous les jeux</a>
</footer>

</body>
</html>
