<?php
require_once 'config.php';
session_start();

// 🔐 Redirection si l'admin n’est pas connecté
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}


// 📅 Récupération des événements
$evenements = $pdo->query("SELECT * FROM evenement ORDER BY date DESC")->fetchAll();

$participants = [];
$nombre_participants = 0;

if (isset($_GET['evenement_id'])) {
    $id = intval($_GET['evenement_id']);

    $stmt = $pdo->prepare("
        SELECT p.nom, p.prenom, p.email, p.accompagnants, i.date_inscription
        FROM inscription i
        JOIN participant p ON i.participant_id = p.id
        WHERE i.evenement_id = ?
        ORDER BY i.date_inscription DESC
    ");
    $stmt->execute([$id]);
    $participants = $stmt->fetchAll();

    $nombre_participants = count($participants);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Participants par Événement</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background: #f9f9f9; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }

        select, button {
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h1 {
            margin-bottom: 20px;
        }

        .export-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #27ae60;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .export-btn:hover {
            background: #1e874b;
        }

        .logout {
            text-align: right;
            margin-bottom: 15px;
        }

        .logout a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="logout">
    <a href="logout.php">🔓 Se déconnecter</a>
</div>

<div class="container">
    <h1>👥 Participants par Événement</h1>

    <form method="GET">
        <label>Sélectionnez un événement :</label><br>
        <select name="evenement_id" required>
            <option value="">-- Choisissez --</option>
            <?php foreach ($evenements as $evt): ?>
                <option value="<?= $evt['id'] ?>" <?= (isset($_GET['evenement_id']) && $_GET['evenement_id'] == $evt['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($evt['titre']) ?> – <?= $evt['date'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Afficher</button>
    </form>

    <?php if (!empty($participants)): ?>
        <a href="admin_export_csv.php?evenement_id=<?= $_GET['evenement_id'] ?>" class="export-btn">
            📤 Exporter en CSV
        </a>

        <p><strong>Nombre total d’inscrits :</strong> <?= $nombre_participants ?></p>

        <h2 style="margin-top: 20px;">Liste des Participants</h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Accompagnants</th>
                <th>Date d'inscription</th>
            </tr>
            <?php foreach ($participants as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nom']) ?></td>
                    <td><?= htmlspecialchars($p['prenom']) ?></td>
                    <td><?= htmlspecialchars($p['email']) ?></td>
                    <td><?= $p['accompagnants'] ?></td>
                    <td><?= $p['date_inscription'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($_GET['evenement_id'])): ?>
        <p><em>Aucun participant inscrit pour cet événement.</em></p>
    <?php endif; ?>
</div>

</body>
</html>
s