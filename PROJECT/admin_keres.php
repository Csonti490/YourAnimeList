<?php 
require "functions.php";
if (isset($_POST['send'])) {
    $conn->query("INSERT INTO admin_uzenetek VALUES(id,$_SESSION[id],'$_POST[uzenet]')");
    echo '<script>alert("Admin üzenet elküldve")</script>';
}
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <?php include_once("metak.php"); ?>
    <?php include_once("linkek_css.php"); ?>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <title>YourAnimeList - Admin Segít</title>
  </head>
  <body>

      <header>
        <?php include_once("nav.php"); ?>
      </header>

      <main>

        <div class="container h-50 text-light my-5" id="httr">
          <div class="p-5 text-center"><hr><h1 class="w-100 py-3">Hibajelentés</h1><hr></div>
        </div>

        <div class="container mt-5 text-center">
          <div class="row">
            <p>Ha bármi hibát tapasztalsz az oldallal kapcsolatban vagy jelenteni akarsz egy felhasználót, akkor azt itt megteheted.</p>
            <form action="admin_keres.php" method="post">
              <div class="col-12">
                <textarea cols="30" rows="10" class="w-100 p-2" name="uzenet" placeholder="Panasz" id="panasz"></textarea>
              </div>
              <div class="col-12 mt-3">
                <input type="submit" class="func_btn p-2" name="send" value="Küldés">
              </div>
            </form>
          </div>
        </div>
       
      </main>
      <footer class="hatternav text-center">
        © SandWitch - 2023
      </footer>

  </body>
  <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="main.js"></script>
</html>
<script>
  /* ---------- Oldalcím és háttér ---------- */
  window.onload = (event) => {
  Keptolt();
  };
  var pictures = ['1.png','2.png','3.jpg','4.jpg','5.jpg','6.jpg'];
  var kephely = document.getElementById("httr");
  function Keptolt(){
  var rand = Math.floor(Math.random() * pictures.length);
  kephely.style.backgroundImage = "url(img/bgc/kep"+pictures[rand]+")";
  }
</script>