<?php
require 'functions.php';
if ($_SESSION['name']!=$conn->query("SELECT * FROM conversations INNER JOIN users ON conversations.sender_id=users.id  WHERE conversations.id=$_GET[conv_id]")->fetch_assoc()['username']){    
    $nev=$conn->query("SELECT * FROM conversations INNER JOIN users ON conversations.sender_id=users.id  WHERE conversations.id=$_GET[conv_id]")->fetch_assoc()['username'];
}
else {
$nev=$conn->query("SELECT * FROM conversations INNER JOIN users ON conversations.adressed_id=users.id  WHERE conversations.id=$_GET[conv_id]")->fetch_assoc()['username'];
}
    echo'<form '/*.action="uzenet.php?conv_id='.$_GET['conv_id'].'"*/.' method="post" id=2 >
        <div class="container m- p-0">
            <div class="row m- p-0">
                <div class="col-10 m-0 p-0">
                    <input class="w-100 uzineki" type="text" name="message" id=4 placeholder="Üzenet neki&nbsp;'."$nev".'">
                </div>
                <div class="col-2 m-0 p-0 text-center">
                    <input type="button" class="send_btn b" name="send_btn"  id=3 max="200" onclick="send('.$_GET['conv_id'].')" value="">
                </div>
            </div>
        </div>
    </form >';
    //<button class="send_btn" onclick="send('.$_GET['conv_id'].')"><i class="fa-solid fa-paper-plane" style="color: var(--sotetlila);"></i></button>
?>
