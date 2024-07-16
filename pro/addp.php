<?php
    include ('navd.php'); // Inclure le menu de navigation
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un prêt</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclure le fichier CSS approprié -->
</head>
<body>
    <main>
        <h1 class="title">Dashboard</h1>
        <ul class="breadcrumbs">
            <li><a href="pret.php">Prêts</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Ajouter</a></li>
        </ul>

        <div class="container">
            <div class="text-center mb-4">
                <h3>Ajouter un prêt</h3>
                <p class="text-muted">Ici, vous pouvez ajouter un nouveau prêt.</p>
            </div>
            <div class="container d-flex justify-content-center">
                <form method="POST" autocomplete="off" style="width:70vw; min-width:300px;">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="form-labe">son association</label>
                            <input type="text" class="form-control" name="id_association" value="<?php echo $ligne['id_association'];?>" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label for="montant">Montant</label>
                            <input type="number" class="form-control" name="montant" min="100" required>
                        </div>
                        <div class="col">
                            <label for="interet">Intérêt</label>
                            <input type="number" class="form-control" name="interet" min="0" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label for="max">Maximum</label>
                            <input type="number" class="form-control" name="max" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="submit">Enregistrer</button>
                        <a href="pret.php" class="btn btn-danger">Annuler</a>
                    </div>

                    <?php
                    if (isset($_POST['submit'])) {
                        // Récupérer les valeurs du formulaire
                        $id_association = $_POST['id_association'];
                        $montant = $_POST['montant'];
                        $interet = $_POST['interet'];
                        $max = $_POST['max'];
                        $statut ='on';

                        // Requête d'insertion pour ajouter un nouveau prêt
                        $query = "INSERT INTO pret (id_association, montant, interet, max,statut) VALUES ('$id_association', '$montant', '$interet', '$max','$statut')";

                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            echo "<script>
                                alert('Prêt ajouté avec succès.');
                                window.location.href = 'pret.php';
                            </script>";
                        } else {
                            echo "<script>
                                alert('Échec de l'ajout du prêt.');
                                window.location.href = 'add_pret.php';
                            </script>";
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
