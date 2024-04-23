<?php
    require "functions.php";
    //echo'<script> console.log('. $_POST['message'].')</script>';
        # code...
        fc_send_message($_POST['message'],$_POST['id']);
        //require "config.php";
        //$conn->query("INSERT INTO messages VALUES(id,$id,$_SESSION[id],'$_POST['message']','".date("Y-n-d H:i:s")."')");
?>