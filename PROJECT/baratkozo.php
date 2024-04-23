<?php 
require "functions.php";
require "config.php";
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
    }
    if (mysqli_num_rows($conn->query("SELECT * FROM conversations WHERE sender_id=$_SESSION[id] AND adressed_id=$_POST[id]  "))==0||mysqli_num_rows($conn->query("SELECT * FROM conversations WHERE  adressed_id=$_POST[id] AND sender_id=$_SESSION[id]  "))==0) {
        $conn->query("INSERT INTO conversations VALUES (id,$_SESSION[id],$_POST[id],'".date("Y-n-d H:i:s")."')");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once("metak.php"); ?>
        <?php include_once("linkek_css.php"); ?>
        <script src="https://code.jquery.com/jquery-latest.js"></script>
        <title>YourAnimeList - Barátkoz</title>
    </head>
    <body>

        <header>
            <?php include_once("nav.php"); ?>
        </header>

        <main>

            <input type="text" name="" id="0" placeholder="barátkeresése"><br>
            <div id="1">
            
            </div>

        </main>

        <footer class="hatternav text-center">
            © SandWitch - 2023-2024
        </footer>

    </body>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
    <script>
        $('#1').load('baratk.php?ker=');
        document.getElementById(0).addEventListener('keyup',()=>{
        console.log(document.getElementById(0).value);
            $('#1').load('baratk.php?ker='+document.getElementById(0).value);
        })
    </script>
</html>