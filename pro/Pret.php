<?php
    include('navd.php'); // Inclure le menu de navigation
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des prêts</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ajouter le fichier CSS approprié -->
</head>
<body>
    <main>
    <form method="POST">
        <h1 class="title">Dashboard - Liste des prêts</h1>
        <ul class="breadcrumbs">
            <li><a href="index.jsp">Accueil</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Prêts</a></li>
        </ul>
        <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changer_statut'])) {
        $id_pre = $_POST['id_pre'];
        $statut_actuel = $_POST['statut_actuel'];

        // Déterminer le nouveau statut
        $nouveau_statut = ($statut_actuel == 'on') ? 'off' : 'on';

        // Mise à jour du statut dans la base de données
        $query = "UPDATE pret SET statut = '$nouveau_statut' WHERE id_pre = '$id_pre'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Statut modifié avec succès.'); window.location.href = 'Pret.php';</script>";
            exit(); // Assurez-vous de quitter après la redirection
        } else {
            echo "<script>alert('Erreur lors de la modification du statut.');</script>";
        }
    }
?>
        <div class="container">
            <a href="addp.php" class="btn btn-outline-info rounded-0 merriweather mb-3">Ajouter un prêt</a>
            
            <div class="row mb-3"> 
                <div class="col">
                    <input type="search" placeholder="Rechercher par montant ou statut" name="re" class="form-control">
                </div>
                <div class="col">
                    <input type="submit" name="btn" value="Rechercher" class="btn btn-primary">
                </div>
            </div>
            
            <table class="table table-striped table-bordered"> <!-- Bordures et rayures -->
            <thead class="thead-dark"> <!-- Entête sombre -->
                <tr>
                    <th>#</th>
                    <th>Montant</th>
                    <th>Intérêt</th>
                    <th>Maximum</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Votre code PHP pour remplir le tableau
                if (isset($_POST['btn'])) {
                    $re = $_POST['re'];
                    // Requête pour rechercher par montant ou statut
                    $req = mysqli_query($conn, "SELECT * FROM pret WHERE id_association = '{$_SESSION['id_association']}' AND (montant LIKE '%{$re}%' OR statut LIKE '%{$re}%')");
                } else {
                    // Requête par défaut pour afficher les 10 premiers prêts
                    $req = mysqli_query($conn, "SELECT * FROM pret WHERE id_association = '{$_SESSION['id_association']}' LIMIT 10");
                }

                while ($ligne = mysqli_fetch_assoc($req)) {
                ?>
                <tr>
                    <td><?php echo $ligne['id_pre']; ?></td>
                    <td><?php echo $ligne['montant']; ?></td>
                    <td><?php echo $ligne['interet']; ?>%</td>
                    <td><?php echo $ligne['max']; ?></td>
                    <td><?php echo $ligne['statut']; ?></td>
                    <td>
                        <!-- Utiliser des icônes pour les actions -->
                        <a href="modp.php?complet=<?php echo $ligne['id_pre']; ?>" class="btn btn-warning btn-sm"><i class='bx bxs-edit'></i> Modifier</a>
                        <form method="post" action="" style="display:inline-block;">
                            <input type="hidden" name="id_pre" value="<?php echo $ligne['id_pre']; ?>">
                            <input type="hidden" name="statut_actuel" value="<?php echo $ligne['statut']; ?>">
                            <button type="submit" name="changer_statut" class="btn btn-outline-secondary btn-sm">Changer Statut</button>
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        </div>
    </form> 
    
    </main>
</body>
</html>
