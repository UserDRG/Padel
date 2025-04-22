<?php
// Informations de connexion à la base de données
$servername = "localhost"; // Généralement localhost pour l'hébergement standard
$username = "votre_nom_utilisateur_bdd"; // À remplacer par votre nom d'utilisateur
$password = "votre_mot_de_passe_bdd"; // À remplacer par votre mot de passe
$dbname = "padel_db"; // Le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Définir le jeu de caractères
$conn->set_charset("utf8");
?>
