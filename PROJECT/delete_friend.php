<?php
    require "config.php";
    session_start();
    $id=$_POST['id'];
    $list=$conn->query("SELECT * FROM friends_list WHERE userid=$_SESSION[id]");
    $list=$list->fetch_assoc();
    $new_list=explode($id.',',$list['friends_id']);
    $vegso_lista='';
    foreach ($new_list as $s) {
        if ($s!=$id.',') {
           $vegso_lista.=$s;
        }
    }
    $conn->query("UPDATE friends_list SET  friends_id='$vegso_lista' WHERE userid=$_SESSION[id]");
    $list=$conn->query("SELECT * FROM friends_list WHERE userid=$id");
    $list=$list->fetch_assoc();
    $new_list=explode($_SESSION['id'].',',$list['friends_id']);
    $vegso_lista='';
    foreach ($new_list as $s) {
        if ($s!=$_SESSION['id'].',') {
           $vegso_lista.=$s;
        }
    }
    $conn->query("UPDATE friends_list SET  friends_id='$vegso_lista' WHERE userid=$id");
    $conn->query("DELETE FROM conversations WHERE sender_id=$_SESSION[id] AND adressed_id=$id");
    $conn->query("DELETE FROM messages WHERE conversation_id=".$conn->query("SELECT * FROM conversations WHERE sender_id=$_SESSION[id] AND adressed_id=$id")->fetch_assoc()['id']."");
    $conn->query("DELETE FROM conversations WHERE sender_id=$id AND adressed_id=$_SESSION[id]");
    header("Refresh:0; url=profil.php");
?>