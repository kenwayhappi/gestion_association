<?php
    include ('navd.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
    <link href="styl.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-0">
                    <div class="chat-main-box">
                        <div class="chat-left-aside">
                            <div class="open-panel"><i class="ti-angle-right"></i></div>
                            <div class="chat-left-inner">
                                <div class="form-material">
                                    <input class="form-control p-20" type="text" placeholder="Search Contact" name="btn">
                                </div>
                                <ul class="chatonline style-none">
                                    <?php
                                        $req = null;
                                        if (isset($_POST['btn']) && !empty($_POST['btn'])) {
                                            $mc = mysqli_real_escape_string($conn, $_POST['btn']);
                                            $req = mysqli_query($conn, "SELECT * FROM membres WHERE (prenom LIKE '%$mc%' OR nom LIKE '%$mc%') AND id_association='" . $_SESSION['id_association'] . "'");
                                            $nbr = mysqli_num_rows($req);
                                            if ($nbr == 0) {
                                                echo "<li>$mc n'est pas enregistré</li>";
                                            }
                                        } else {
                                            $req = mysqli_query($conn, "SELECT * FROM membres WHERE id_association='" . $_SESSION['id_association'] . "' LIMIT 10");
                                        }

                                        while ($ligne = mysqli_fetch_assoc($req)) {
                                            echo '<li>';
                                            echo '<a href="chat.php?complet=' . $ligne['id_membre'] . '"><img src="' . $ligne['photo'] . '" width="48"><span>';
                                            echo $ligne['nom'] . " - " . $ligne['prenom'];
                                            echo '<small class="text-success">' . $ligne['statut'] . '</small></span></a>';
                                            echo '</li>';
                                        }
                                    ?>
                                    <li class="p-20"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="chat-right-aside">
                            <div class="chat-main-header">
                                <div class="p-20 b-b">
                                    <h3 class="box-title">Chat Message</h3>
                                </div>
                                <div class="chat-rbox">
                                    <ul class="chat-list p-20">
                                        <?php
                                            if (isset($_GET['complet'])) {
                                                $user_id = mysqli_real_escape_string($conn, $_GET['complet']);
                                                $sql = mysqli_query($conn, "SELECT * FROM membres WHERE id_membre = {$user_id}");
                                                if (mysqli_num_rows($sql) > 0) {
                                                    $row = mysqli_fetch_assoc($sql);
                                                   
                                                } else {
                                                    header("Location: chat.php");
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="card-body b-t">
                                    <div class="row">
                                        <div class="col-8">
                                            <textarea placeholder="Type your message here" class="form-control b-0"></textarea>
                                        </div>
                                        <div class="col-4 text-right">
                                            <button type="button" class="btn btn-info btn-circle btn-lg"><i class="fa fa-paper-plane-o"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
