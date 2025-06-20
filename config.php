<?php
// Configuration de la base de données

define('DB_HOST', 'localhost');
define('DB_NAME', 'projetAPP');    // Nom exact de ta base
define('DB_USER', 'root');         // Par défaut en local avec XAMPP/WAMP/MAMP
define('DB_PASS', '');             // Mot de passe vide si tu n'en as pas mis

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
