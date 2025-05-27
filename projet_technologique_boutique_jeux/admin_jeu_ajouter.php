<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un jeu</title>
</head>
<body>
<h1>Ajouter un nouveau jeu</h1>
<form action="admin_jeu_traitement.php" method="post" enctype="multipart/form-data">
    <label>Nom du jeu : <input type="text" name="nom" required></label><br><br>
    <label>Image (jpg/png) : <input type="file" name="image" accept="image/*"></label><br><br>
    <label>Type : <input type="text" name="type"></label><br><br>
    <label>Genre : <input type="text" name="genre"></label><br><br>
    <label>Année de sortie : <input type="number" name="annee_sortie"></label><br><br>
    <label>Description courte : <br><textarea name="description_courte" rows="3" cols="50"></textarea></label><br><br>
    <label>Description longue : <br><textarea name="description_longue" rows="5" cols="50"></textarea></label><br><br>
    <button type="submit">Ajouter le jeu</button>
</form>
</body>
</html>
