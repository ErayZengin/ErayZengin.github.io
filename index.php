<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de tâches</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Ajouter une tâche à l'agenda</h2>
        <form method="POST" class="task-form">
            <label for="title">Nom de la tâche :</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="description">Description de la tâche :</label><br>
            <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

            <input type="submit" value="Ajouter la tâche">
        </form>

        <div class="task-list">
            <?php
            require("connect.php");

            if ($_POST) {
                $stmt = $db->prepare("INSERT INTO task (title, description, completed) VALUES (?, ?, 0)");
                $stmt->bind_param("ss", $_POST['title'], $_POST['description']);
                $stmt->execute();

                header("Location: index.php");
            }

            if(isset($_GET['complete']) && !empty($_GET['complete'])){
                $complete_id = $_GET['complete'];
                $stmt = $db->prepare("UPDATE task SET completed=1 WHERE id=?");
                $stmt->bind_param("i", $complete_id);
                $stmt->execute();
                header("Location: index.php");
            }

            if(isset($_GET['undo']) && !empty($_GET['undo'])){
                $undo_id = $_GET['undo'];
                $stmt = $db->prepare("UPDATE task SET completed=0 WHERE id=?");
                $stmt->bind_param("i", $undo_id);
                $stmt->execute();
                header("Location: index.php");
            }

            $result = $db->query("SELECT * FROM task");

            if ($result->num_rows > 0) {
                while ($task = $result->fetch_assoc()) {
                    echo "<div class='task'>";
                    echo ($task['completed'] ? "<del>" : ""); // Barre le titre de la tâche si elle est complétée
                    echo "<h3>{$task["title"]}</h3>";
                    echo ($task['completed'] ? "</del>" : "");
                    echo "<p>{$task["description"]}</p>";
                    echo "<div class='task-actions'>";
                    if (!$task['completed']) {
                        echo "<a href='?complete={$task['id']}' class='complete-button'>Complétée</a>";
                    } else {
                        echo "<a href='?undo={$task['id']}' class='undo-button'>Annuler complétion</a>";
                    }
                    echo "<a href='update.php?update={$task['id']}'>Modifier</a> <a href='delete.php?delete={$task['id']}'>Supprimer</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-tasks'>Aucune tâche trouvée...</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>

