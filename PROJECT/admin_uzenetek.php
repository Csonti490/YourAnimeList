<?php
    require 'functions.php';
    $uzenetek=$conn->query("SELECT * FROM admin_uzenetek");
    while ($uzenet=$uzenetek->fetch_assoc()) {
        echo 'Írta: '.$conn->query("SELECT * FROM users WHERE id=$uzenet[felado]")->fetch_assoc()['username'].' | Üzenet: '.$uzenet['uzenet'].'<br>';
    }
?>