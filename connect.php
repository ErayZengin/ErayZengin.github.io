<?php
$servername = "localhost"; // On travaille en local
$username = "root"; // "root" par défaut sous MAMP, XAMPP et WAMP
$password = "root"; // "root" sous WAMP
$dbname = "todo_list"; // Nom de la base de données MySQL

// Créé la connexion à la base
$db = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($db->connect_error) { // Si une erreur de connexion est survenue
  die("Échec de la connexion: " . $db->connect_error);
}
?>