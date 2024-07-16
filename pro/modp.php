<?php
    include('navd.php');
    $complet = $_GET['complet'];
    $res = mysqli_query($conn, "SELECT * FROM pret WHERE id_pre='$complet'");

    if ($ligne = mysqli_fetch_assoc($res)) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un prêt</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclure le fichier CSS approprié -->
</head>
<body>
    <main>
        <h1 class="title">Modifier un prêt</h1>
        <ul class="breadcrumbs">
            <li><a href="pret.php">Prêts</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Modifier</a></li>
        </ul>

        <div class="container">
            <div class="text-center mb-4">
                <h3>Modifier un prêt</h3>
                <p class="text-muted">Modifiez les détails du prêt ci-dessous.</p>
            </div>

            <div class="container d-flex justify-content-center">
                <form method="POST" autocomplete="off" style="width:70vw; min-width:300px;">
                    <div class="row mb-3">
                        <div class="col">
                            <label>Association</label>
                            <input type="text" class="form-control" name="id_association" value="<?php echo $ligne['id_association']; ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label>Montant</label>
                            <input type="text" class="form-control" name="montant" value="<?php echo $ligne['montant']; ?>" required>
                        </div>
                        <div class="col">
                            <label>Intérêt</label>
                            <input type="number" class="form-control" name="interet" value="<?php echo $ligne['interet']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label>Maximum</label>
                            <input type="number" class="form-control" name="max" value="<?php echo $ligne['max']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="submit">Enregistrer</button>
                        <a href="pret.php" class="btn btn-danger">Annuler</a>
                    </div>

                    <?php
                    if (isset($_POST['submit'])) {
                        // Obtenir les valeurs du formulaire
                        $montant = $_POST['montant'];
                        $interet = $_POST['interet'];
                        $max = $_POST['max'];
                        
                        // Requête de mise à jour
                        $reqmod = "UPDATE pret SET 
                        montant = '$montant', 
                        interet = '$interet', 
                        max = '$max' 
                        WHERE id_pre = '$complet'";

                        $res = mysqli_query($conn, $reqmod);

                        if ($res) {
                            echo "<script>
                                alert('Prêt modifié avec succès.');
                                window.location.href = 'pret.php';
                            </script>";
                        } else {
                            echo '<div class="alert alert-danger" role="alert"><strong>Échec de la modification du prêt!</strong></div>';
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
<?php
    } // Fin de la condition if (mysqli_fetch_assoc)
?>
