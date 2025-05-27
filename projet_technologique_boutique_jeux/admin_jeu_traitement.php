<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require_once 'config.php';

$nom = $_POST['nom'] ?? '';
$type = $_POST['type'] ?? '';
$genre = $_POST['genre'] ?? '';
$annee_sortie = $_POST['annee_sortie'] ?? null;
$desc_courte = $_POST['description_courte'] ?? '';
$desc_longue = $_POST['description_longue'] ?? '';
$image_name = null;

// Gérer l'upload
if (!empty($_FILES['image']['tmp_name'])) {
    $tmp = $_FILES['image']['tmp_name'];
    $name = basename($_FILES['image']['name']);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
        $new_name = uniqid() . '.' . $ext;
        move_uploaded_file($tmp, 'uploads/' . $new_name);
        $image_name = $new_name;
    }
}

$sql = "INSERT INTO jeu (nom, image, type, genre, annee_sortie, description_courte, description_longue) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nom, $image_name, $type, $genre, $annee_sortie, $desc_courte, $desc_longue]);

echo "🎉 Jeu ajouté avec succès ! <a href='admin_dashboard.php'>Retour au tableau de bord</a>";
?>
