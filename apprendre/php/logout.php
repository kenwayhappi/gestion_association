<?php
    session_start();
    if(isset($_SESSION['id_membre'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE membres SET status = '{$status}' WHERE id_membre={$_GET['logout_id']}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../chat.php");
        }
    }else{  
        header("location: ../membre.php");
    }
?>