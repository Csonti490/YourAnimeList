<?php
  require "functions.php";
  if (isset($_POST['delet'])) {
    $d_user=$conn->query("SELECT * FROM users WHERE id=$_POST[id]")->fetch_assoc();
    $conn->query("DROP TABLE $d_user[malname]");
    $lists=$conn->query("SELECT * FROM friends_list WHERE friends_id	 LIKE '%$_SESSION[id],%'");
    while ($list=$lists->fetch_assoc()) {
        $new_list=explode($_SESSION['id'].',',$list['friends_id']);
        $vegso_lista='';
        foreach ($new_list as $s) {
            if ($s!=$_SESSION['id'].',') {
               $vegso_lista.=$s;
            }
        }
        $conn->query("UPDATE friends_list SET  friends_id='$vegso_lista' WHERE userid=$list[userid]");
    }
    $conn->query("DELETE FROM friends_list WHERE userid=$_SESSION[id]");
    $conn->query("DELETE FROM `conversations` WHERE `sender_id`= $_SESSION[id] OR `adressed_id`= $_SESSION[id]");
    $conn->query("DELETE FROM `Acsses_tokens` WHERE Userid = $_SESSION[id]");
    $conn->query("DELETE FROM `users` WHERE id=$d_user[id]");
  }
?>  
<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <?php include_once("metak.php"); ?>
    <?php include_once("linkek_css.php"); ?>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <title>YourAnimeList - Hírfolyam</title>
    <!--<meta http-equiv="refresh" content="5">-->
  </head>
  <body>
      <header>
        <?php include_once("nav.php"); ?>
      </header>    
      <main>
        <h1 class="text-center m-3">Segítségkérések</h1>
        <div class="mt-5">
          <button id="0" class="func_btn p-1">Frissítés</button>
        <div id="1">
        
        </div>

        <hr>

        <h1 class="text-center m-3">Felhasználók</h1>
        <table class="mx-auto w-50">
        <tr class="bottom"><th>username</th><th>mail</th><th>malname</th><th>rank</th><th>&nbsp;</th></tr>
            <?php
            $users=$conn->query("SELECT * FROM users");
                while ($user=$users->fetch_assoc()) {
                    echo '<tr><td>'.$user['username'].' </td><td>'.$user['mail'].' </td><td>'.$user['malname'].' </td><td>'.$user['rank'].' </td><td><form method="post" action="admin.php"><input type="text" name="id" value="'.$user['id'].'" style="display:none;"><input type="submit" class="func_btn p-1" name="delet" value="Törlés"></form></td></tr>';
                }
            ?>
            
        </table>
        </div>
        
      </main>

      <footer class="hatternav text-center">
        © SandWitch - 2023
      </footer>
  </body>
  <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="main.js"></script>
  <script>
     $('#1').load('admin_uzenetek.php');
    var doboz= document.getElementById(1);
    document.getElementById(0).addEventListener('click',()=>{
        $('#1').load('admin_uzenetek.php');
    })
  </script>
  </html>