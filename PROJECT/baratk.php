<div class="container">
    <div class="row">
<?php
    require "config.php";
    session_start();
    if (isset($_POST['baratkozo'])) {
        $nye=$conn->query("SELECT * FROM friends_list WHERE userid=$_SESSION[id]");
        if (mysqli_num_rows($nye)!=0) {
            $conn->query("UPDATE friends_list SET friends_id= CONCAT(friends_id,'$_POST[id],') WHERE userid=$_SESSION[id]");
            $nye=$conn->query("SELECT * FROM friends_list WHERE userid=$_POST[id]");
            if (mysqli_num_rows($nye)!=0) {
                $conn->query("UPDATE friends_list SET friends_id= CONCAT(friends_id,'$_SESSION[id],') WHERE userid=$_POST[id]");
            }
            else {
                $conn->query("INSERT INTO friends_list VALUES(id,$_POST[id],'$_SESSION[id],')");
            }
        }
        else {
            $conn->query("INSERT INTO friends_list VALUES(id,$_SESSION[id],'$_POST[id],')");
            echo'<script>alert("<3")</script>';
            $nye=$conn->query("SELECT * FROM friends_list WHERE userid=$_POST[id]");
            if (mysqli_num_rows($nye)!=0) {
                $conn->query("UPDATE friends_list SET friends_id= CONCAT(friends_id,'$_SESSION[id],') WHERE userid=$_POST[id]");
            }
            else {
                $conn->query("UPDATE friends_list SET friends_id= CONCAT(friends_id,'$_SESSION[id],') WHERE userid=$_POST[id]");
                $conn->query("INSERT INTO friends_list VALUES(id,$_POST[id],'$_SESSION[id],')");
            }
        }
        if (mysqli_num_rows($conn->query("SELECT * FROM conversations WHERE sender_id=$_SESSION[id] AND adressed_id=$_POST[id]  "))==0||mysqli_num_rows($conn->query("SELECT * FROM conversations WHERE  adressed_id=$_POST[id] AND sender_id=$_SESSION[id]  "))==0) {
            $conn->query("INSERT INTO conversations VALUES (id,$_SESSION[id],$_POST[id],'".date("Y-n-d H:i:s")."')");
        }
    }
     if (isset($_GET['ker'])) {
        $felhasznalok=$conn->query("SELECT * FROM users WHERE username LIKE '%$_GET[ker]%'");
    }
    else {
        $felhasznalok=$conn->query("SELECT * FROM users");
    }
    if (mysqli_num_rows($felhasznalok)!=0) {
        if (mysqli_num_rows($conn->query("SELECT* FROM friends_list WHERE userid=$_SESSION[id]"))!=0) {
            $baratok=$conn->query("SELECT* FROM friends_list WHERE userid=$_SESSION[id]")->fetch_assoc()['friends_id'];
        }
        else {
            $baratok='0';
        }
        while ($felhasznalo=$felhasznalok->fetch_assoc()) {
            if ($felhasznalo['id']!=$_SESSION['id']&&!str_contains($baratok,$felhasznalo['id'])) {
                echo'<div class="col-lg-2 col-md-3 col-sm-4 col-6 p-0">
                    <div class="a_doboz mx-2 my-2">
                        <img src="'.$felhasznalo['img'].'" alt="Nem sikerült betölteni a képet" class="mx-auto d-block w-100 a_kep">
                        <div class="a_szoveg">
                            <h4>'.$felhasznalo['username'].'</h4>
                            <div class="kozep">
                                <form action="baratkozo.php" method="post" class="text-center">
                                    <input style="display:none;" type="text" name="id" value="'.$felhasznalo['id'].'" id=""><input class="friending" type="submit"  name="baratkozo" value="&nbsp;" id="">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }
    }
    else {
        echo 'Nincs ilyen felhasználo';
    }
?>
    </div>
</div>