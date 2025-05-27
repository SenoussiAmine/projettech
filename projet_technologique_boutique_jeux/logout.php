<?php
session_start();        // On démarre la session
session_unset();        // On vide toutes les variables de session
session_destroy();      // On détruit la session complètement

header('Location: login.php');  // On renvoie vers la page de connexion
exit;
?>
