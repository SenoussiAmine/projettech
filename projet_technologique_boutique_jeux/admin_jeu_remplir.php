<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}


$jeux = [
    ['UNO', 'uno.jpg', 'Cartes', 'Famille', 1971, 'Jeu de cartes rapide', 'Jeu de cartes simple et rapide pour tout âge.'],
    ['Cartes Pokémon', 'pokemon.jpg', 'Cartes', 'Collection', 1996, 'Collection et combat', 'Collectionnez et combattez avec vos Pokémon préférés.'],
    ['Loup-Garou', 'loup-garou.jpg', 'Cartes', 'Déduction', 2001, 'Jeu de rôle caché', 'Incarnez un villageois ou un loup-garou dans ce jeu d’ambiance.'],
    ['La Bonne Paye', 'bonne-paye.jpg', 'Plateau', 'Famille', 2002, 'Gestion d’argent amusante', 'Payez vos factures et tentez de finir riche à la fin du mois.'],
    ['Monopoly', 'monopoly.jpg', 'Plateau', 'Économie', 1935, 'Achat et gestion de propriétés', 'Achetez des rues, bâtissez des maisons et ruinez vos amis.'],
    ['Yu-Gi-Oh!', 'yugioh.jpg', 'Cartes', 'Stratégie', 1999, 'Duel de monstres', 'Invoquez des monstres puissants pour vaincre votre adversaire.'],
    ['Catan', 'catan.jpg', 'Plateau', 'Stratégie', 1995, 'Colonisation de l’île', 'Échangez, construisez et développez votre colonie.'],
    ['Dixit', 'dixit.jpg', 'Cartes', 'Créatif', 2008, 'Jeu d’imagination', 'Interprétez des images mystérieuses et devinez celles des autres.'],
    ['Risk', 'risk.jpg', 'Plateau', 'Guerre', 1959, 'Conquête du monde', 'Prenez le contrôle de continents et dominez le monde.'],
    ['Les Aventuriers du Rail', 'aventuriers-rail.jpg', 'Plateau', 'Transport', 2004, 'Construction de réseau ferroviaire', 'Reliez les villes les plus célèbres par le train.'],
    ['7 Wonders', 'wonders.jpg', 'Cartes', 'Civilisation', 2010, 'Développement antique', 'Construisez une cité antique et menez-la à la victoire.'],
    ['Cluedo', 'cluedo.jpg', 'Plateau', 'Enquête', 1949, 'Qui est le meurtrier ?', 'Résolvez le mystère du manoir Tudor.'],
    ['Carcassonne', 'carcassonne.jpg', 'Plateau', 'Placement', 2000, 'Pose de tuiles', 'Construisez une ville médiévale avec vos tuiles.'],
    ['Scrabble', 'scrabble.jpg', 'Plateau', 'Lettres', 1938, 'Mots et lettres', 'Formez des mots pour marquer le plus de points possible.'],
    ['Azul', 'azul.jpg', 'Plateau', 'Tactique', 2017, 'Mosaïque portugaise', 'Posez de belles mosaïques en stratégie.'],
    ['Code Names', 'codenames.jpg', 'Cartes', 'Déduction', 2015, 'Espions et mots', 'Devinez les bons mots en évitant les pièges.'],
    ['Small World', 'smallworld.jpg', 'Plateau', 'Fantastique', 2009, 'Conquête humoristique', 'Prenez possession d’un monde trop petit pour tout le monde.'],
    ['Blokus', 'blokus.jpg', 'Plateau', 'Puzzle', 2000, 'Tetris de plateau', 'Placez vos pièces pour bloquer vos adversaires.'],
    ['Jungle Speed', 'junglespeed.jpg', 'Réflexe', 'Ambiance', 1997, 'Jeu de totem', 'Attrapez le totem le plus vite possible en cas de symbole identique.'],
    ['Time’s Up!', 'timesup.jpg', 'Ambiance', 'Devine', 2003, 'Deviner en un temps limité', 'Faites deviner des personnages connus à votre équipe.'],
];

$sql = "INSERT INTO jeu (nom, image, type, genre, annee_sortie, description_courte, description_longue) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

foreach ($jeux as $jeu) {
    $stmt->execute($jeu);
}

echo "🎉 20 nouveaux jeux ont été ajoutés avec succès dans la base de données.";
?>
