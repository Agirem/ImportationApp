<?php
$servername = "localhost"; // Adresse du serveur MySQL (peut être "localhost" si la base de données est sur le même serveur)
$username = "root"; // Votre nom d'utilisateur MySQL
$password = ""; // Votre mot de passe MySQL
$dbname = "berenice"; // Le nom de votre base de données

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

