<?php include_once "nav.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
     $complet = $_GET['complet'];
     $res = mysqli_query($conn, "SELECT * FROM pret WHERE id_pre='$complet'");
 
     if ($banque = mysqli_fetch_assoc($res)) {
        ?>
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="membre.php">confirmer</a></li>
                        <li class="breadcrumb-item active">reglement</li>
                    </ol>
                </div>
            </div>
    <div class="container">
        <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body">
                            <h3 class="box-title m-b-0">Valider vous ce prêt ?</h3>
                            <form method="POST" autocomplete="" enctype="multipart/form-data" >
                            <?php

                            if(isset($_POST['submit'])) 
                            {
                            
    $id_association= $rows['id_association'];  
    $max= $_POST['max'];   
    $total= $_POST['total'];  
    $id_membre=$rows['id_membre'];
    $vrai=$rows['mdp'];
    $date_pret = $_POST['Date_pret'];
    $date_rembou = $_POST['date_rembou'];
    $nom = $_POST['nom'];
    $prenom=$_POST['prenom'];
    $interet=$_POST['interet'];
    $montant=$_POST['montant'];
    $mdpe=$_POST['mdp'];
    $mdp=hash('sha256',$mdpe);

    $statut="attente";
    $dif_jour = strtotime($date_rembou) - strtotime($date_pret);
    $jours_restant = floor($dif_jour / (60 * 60 * 24));
    
            if($mdp!=$vrai){
                echo '<div class="alert alert-danger" role="alert"><strong>Vous avez ratez votre mot de passe!</strong></div>';
            }else{
                if($jours_restant <= $max){
                    $res=mysqli_query($conn,"INSERT INTO demande_emprunt (id_association,id_membre,nom,prenom,montant,interet,date_pret,date_rembou,jour,total,statut) 
                    VALUES ('$id_association','$id_membre','$nom','$prenom','$montant','$interet','$date_pret','$date_rembou','$max','$total','$statut')");

                    if ($res){
                        mysqli_query($conn,"UPDATE  membres SET statut='demande_pret' WHERE id_membre='$id_membre'");
                        echo "<script>
                        alert(\"demande envoyer $jours_restant \");
                        window.location.href = \"Gestion_emprunt.php\";
                        </script>";
                    }else{
                        echo "<script>
                        alert(\"echec de l'envoie \");
                        window.location.href = \"preter.php\";
                    </script>";}
                }else{
                    echo '<div class="alert alert-danger" role="alert"><strong>echec date de remboursement trop eloigné vous 
                    avez mit '.$jours_restant.' pour rembourser!</strong></div>';
            }}
              
            }
            
    
?>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <form>
                <div class="form-group">
                    <input type="text" class="form-control" aria-label="basic-addon1" name="nom" value="<?php echo $rows['nom'];?>" readonly>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" aria-label="basic-addon1" name="prenom" value="<?php echo $rows['prenom'];?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">montant</label>
                    <input type="text" class="form-control" aria-label="basic-addon1" name="montant" value="<?php echo $banque['montant'];?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">interet</label>
                    <input type="text" class="form-control" aria-label="basic-addon1" name="interet" value="<?php echo $banque['interet'];?>%" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Date_pret</label>
                    <input type="text" class="form-control" aria-label="basic-addon1" name="Date_pret"  value="<?php $Dte_pret= date('Y-m-d'); echo $Dte_pret;?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">date_rembou</label>
                    <input type="date" class="form-control" aria-label="basic-addon1" name="date_rembou"  required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Duree_maximal_du_prêt</label>
                    <input type="number" class="form-control" aria-label="basic-addon1" name="max"  value="<?php echo $banque['max'] ;?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Montant a Rembourser</label>
                    <input type="number" class="form-control" aria-label="basic-addon1" name="total"  value="<?php echo $banque['montant'] +($banque['montant'] * $banque['interet'] )/100 ;?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" aria-label="basic-addon1" name="mdp">
                </div>
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" name="submit">Submit</button>
                <button type="reset" class="btn btn-inverse waves-effect waves-light">Cancel</button>
            </form>
     <?php
         }
    ?>
    </div>   
</body>
</html>