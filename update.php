<?php
        require("connect.php"); // Rend disponible la variable '$db' de connexion à la base de données

        if(isset($_GET['update'])) { // Si l'id de la tâche se trouve dans l'URL sous la clé 'update'
            $stmt = $db->prepare("SELECT * FROM task WHERE id=?"); // Requête SQL pour récupérer la tâche par son 'id'
            $stmt->bind_param("i", $_GET['update']);
            $stmt->execute();

            $result = $stmt->get_result(); // Récupère la tâche correspondante
            if($result->num_rows > 0) { // S'il y a plus de tâche
                $task = $result->fetch_assoc(); // Stocke la tâche dans la variable 'task'
        ?>
            <main>  <!-- Affichez ici le formulaire HTML avec les valeurs $task['title'] et $task['description'] pré-remplies (attribut 'value') -->
                <form method="POST">
                    <label for="title">Titre :</label><br>
                    <input type="text" id="title" name="title" value="<?php echo $task['title']; ?>" required><br><br>
                    <label for="description">Description :</label><br>
                    <textarea id="description" name="description" rows="4" cols="50"><?php echo $task['description']; ?></textarea><br><br>
                    <input type="submit" value="Modifier">
                </form>
         </main>
        <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si le formulaire est soumis
                    $stmt = $db->prepare("UPDATE task SET title=?, description=? WHERE id=?"); // Requête SQL pour modifier la tâche
                    $stmt->bind_param("ssi", $_POST['title'], $_POST['description'], $task['id']);
                    $stmt->execute();

                    header("Location: index.php"); // Redirige l'utilisateur vers la page principale après la modification
                    exit();
                }
            }
        }
    ?>