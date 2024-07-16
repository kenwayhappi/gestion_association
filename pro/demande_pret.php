<?php
include('navd.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des demandes</title>
    <style>
        .btn-outline-red {
            color: red;
            border: 1px solid red;
        }

        .btn-outline-red:hover {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <main>
        <h1 class="title">Dashboard</h1>
        <ul class="breadcrumbs">
            <li><a href="gemprunt.php">Demande de prêt</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Liste des demandes</a></li>
        </ul>
        <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Accepter'])) {
        $id_de = $_POST['id_de'];
        $statut_actuel = $_POST['statut_actuel'];

        // Déterminer le nouveau statut
        $nouveau_statut = ($statut_actuel == 'attente') ? 'accepter' : 'attente';

        // Mise à jour du statut dans la base de données
        $query = "UPDATE demande_emprunt  SET statut = '$nouveau_statut' WHERE id_de = '$id_de'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Statut modifié avec succès.'); window.location.href = 'demande_pret.php';</script>";
            exit(); // Assurez-vous de quitter après la redirection
        } else {
            echo "<script>alert('Erreur lors de la modification du statut.');</script>";
        }
    }else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Refuser'])) {
        $id_de = $_POST['id_de'];
        $statut_actuel = $_POST['statut_actuel'];

        // Déterminer le nouveau statut
        $nouveau_statut = ($statut_actuel == 'attente') ? 'refuser' : 'attente';

        // Mise à jour du statut dans la base de données
        $query = "UPDATE demande_emprunt  SET statut = '$nouveau_statut' WHERE id_de = '$id_de'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Statut modifié avec succès.'); window.location.href = 'demande_pret.php';</script>";
            exit(); // Assurez-vous de quitter après la redirection
        } else {
            echo "<script>alert('Erreur lors de la modification du statut.');</script>";
        }
    }
?>
        <div class="container">
            <div class="text-center mb-4">
                <h3>Liste des personnes voulant un prêt</h3>
                <p class="text-muted">Ici vous voyez tous les membres souhaitant un prêt dans votre association</p>
            </div>
            <div class="container d-flex justify-content-center">
                <?php
                $req = mysqli_query($conn, "SELECT * FROM demande_emprunt 
                                            WHERE id_association='{$_SESSION['id_association']}' 
                                            AND statut = 'attente'");
                if (mysqli_num_rows($req) > 0) {
                ?>
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nom - Prénom</th>
                            <th scope="col">Montant - Intérêt</th>
                            <th scope="col">Date de demande</th>
                            <th scope="col">Date de remboursement</th>
                            <th scope="col">Total</th>
                            <th>Régler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($banque = mysqli_fetch_assoc($req)) {
                        ?>
                        <tr>
                            <td><?php echo $banque['nom'] . " - " . $banque['prenom']; ?></td>
                            <td><?php echo $banque['montant'] . " - " . $banque['interet'] . "%"; ?></td>
                            <td><?php echo $banque['date_pret']; ?></td>
                            <td><?php echo $banque['date_rembou']; ?></td>
                            <td><?php echo $banque['total']; ?></td>
                            <td>
                            <form method="post" action="" style="display:inline-block;">
                                    <input type="hidden" name="id_de" value="<?php echo $banque['id_de']; ?>">
                                    <input type="hidden" name="statut_actuel" value="<?php echo $banque['statut']; ?>">
                                    <button type="submit" name="Accepter" class="btn btn-outline-primary btn-sm">Accepter</button>
                                    <button type="submit" name="Refuser" class="btn btn-outline-red btn-sm">Refuser</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                        } 
                        ?>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "<p>Aucune demande pour le moment.</p>";
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
        </div>   
        </form>
    </main>
</body>
</html>