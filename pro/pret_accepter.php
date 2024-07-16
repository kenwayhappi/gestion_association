<?php
include('navd.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prêts Acceptés</title>
</head>
<body>
    <main>
        <h1 class="title">Prêts Acceptés</h1>
        <ul class="breadcrumbs">
            <li><a href="gemprunt.php">Gestions des prêts</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Liste des prêts acceptés</a></li>
        </ul>
        <div class="container">
            <div class="text-center mb-4">
                <h3>Liste des personnes ayant obtenu un prêt</h3>
                <p class="text-muted">Ici vous voyez tous les membres qui ont reçu un prêt dans votre association</p>
            </div>
            <div class="container d-flex justify-content-center">
                <?php
                $req = mysqli_query($conn, "SELECT * FROM demande_emprunt 
                                           WHERE id_association='{$_SESSION['id_association']}' 
                                           AND statut = 'accepter'");

                if (mysqli_num_rows($req) > 0) {
                ?>
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nom - Prénom</th>
                            <th scope="col">Montant - Intérêt</th>
                            <th scope="col">Date de prêt</th>
                            <th scope="col">Date de remboursement</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($demande = mysqli_fetch_assoc($req)) {
                            $nom = $demande['nom'];
                            $prenom = $demande['prenom'];
                            $montant = $demande['montant'];
                            $interet = $demande['interet'];
                            ?>
                            <tr>
                                <td><?php echo $nom . " - " . $prenom; ?></td>
                                <td><?php echo $montant . " - " . $interet . "%"; ?></td>
                                <td><?php echo $demande['date_pret']; ?></td>
                                <td><?php echo $demande['date_rembou']; ?></td>
                                <td><?php echo $demande['total']; ?>FCFA</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "<p>Aucun prêt accepté pour le moment.</p>";
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
