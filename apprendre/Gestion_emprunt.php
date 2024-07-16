<?php include_once "nav.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Emprunt</title>
</head>
<body>
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
                        <li class="breadcrumb-item"><a href="membre.php">Gestion Emprunt</a></li>
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
            <div class="row">
                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8"><h2>Statut Pour Pret <i class="ti-angle-down font-14 text-danger"></i></h2>
                                        <h4>
                                            <?php 
                                                $lien="reglerA.php";
                                                $lien="accept.php";
                                                if($text != null AND $text['statut']=="attente"){
                                                    $texte = "Attente";
                                                echo"<a href='$lien'>$texte</a>";
                                                }else if($text != null AND $text['statut']=="accepter"){
                                                
                                                ?>
                                                <a href="../fac/facEmprunt.php?complet=<?php echo $text['id_de'];?>">Accepter</a>
                                                <?php 
                                                
                                                }else if($text == null){ 
                                                    echo "normal";
                                                }
                                            ?>
                                        </h4></div>
                                    <div class="col-4 align-self-center text-right  p-l-0">
                                        <div id="sparklinedash3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8"><h2>Pret disponible<i class="ti-angle-down font-14 text-danger"></i></h2>
                                        <h4>
                                        <a href="pret.php">Liste</a>
                                        </h4></div>
                                    <div class="col-4 align-self-center text-right  p-l-0">
                                        <div id="sparklinedash3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
        
                </div>
</body>
</html>