<?php
require("./connect.php"); // Rend disponible la variable `$db` de connexion à la base de données  

if($_GET['delete']) { // Si l'id de la tâche est dans l'URL, sous la clé 'delete'
  $stmt = $db->prepare("DELETE FROM task WHERE id=?"); // Requête SQL pour supprimer la tâche
  $stmt->bind_param("i", $_GET['delete']);
  $stmt->execute();

  header("Location: index.php"); // Redirige l'utilisateur vers la page principale après la suppression
}