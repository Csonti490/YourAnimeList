<?php
  
  require "functions.php";

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kepid = isset($_POST["kepid"]) ? $_POST["kepid"] : "";
    $kepid = !empty($kepid) ? $kepid : "";

    if (!empty($kepid)) {
      $talalt_kep = $conn->query("SELECT * FROM folista WHERE malid = $kepid");
      $kep = $talalt_kep->fetch_assoc();
      
      if ($kep) {
        $conn->query("INSERT INTO `news`(`id`, `sender`, `title`, `text`, `picture`, `link`, `postdate`) VALUES (id,'$_SESSION[name]','$_POST[cim]','$_POST[szoveg]','$kep[picture]','$_POST[link]',NOW())");
        echo "<script>alert('Új hír közzétéve!')</script>";
        header("Location: hirfolyam.php");
      } else {
        echo "<script>alert('Hiba: Nem található kép a megadott ID-vel!')</script>";
      }
    } else {
      $conn->query("INSERT INTO `news`(`id`, `sender`, `title`, `text`, `picture`, `link`, `postdate`) VALUES (id,'$_SESSION[name]','$_POST[cim]','$_POST[szoveg]','','$_POST[link]',NOW())");
      echo "<script>alert('Új hír közzétéve!')</script>";
      header("Location: hirfolyam.php");
    }
  }

?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <?php include_once("metak.php"); ?>
    <?php include_once("linkek_css.php"); ?>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <title>YourAnimeList - Hírfolyam</title>
  </head>
  <body>
      <header>
        <?php include_once("nav.php"); ?>
      </header>
      
      <main>

        <div class="container h-50 text-light my-5" id="httr">
          <div class="p-5 text-center"><hr><h1 class="w-100 py-3">Hírfolyam</h1><hr></div>
        </div>
      
        <?php if(!empty($_SESSION['id'])){ if($_SESSION['rank'] == "admin" || $_SESSION['rank'] == "partner") {?>
        <div class="container">
          <form action="hirfolyam.php" method="post" id="hirform">
            <div class="row">
              <div class="col-12">
                  <input type="hidden" name="kepid" id="kepid" value="">
                  <input class="w-100" type="text" name="cim" placeholder="A hír címe" required>
                  <textarea class="w-100 p-2" name="szoveg" maxlength="1000" cols="30" rows="10" placeholder="A hír tartalma..." required></textarea>
                  <input class="w-100" type="text" name="link" placeholder="Forrásmegjelölés">
                  <div class="text-center m-0 p-0">
                    <label>Kiválasztott kép azonosítója:</label>
                    <input type="text" name="kep" id="eredmeny" placeholder="Jelenleg nincsen kép kiválasztva." disabled>
                  </div>
              </div>
              <div class="col-12 text-center mb-3">
                <span class="func_btn p-1" data-bs-toggle="modal" data-bs-target="#Kivalasztas">Anime kiválasztása</span>
                <input type="reset" class="func_btn p-1" onclick="Kepmentes('megsem');KepValaszt('megse')" value="Mégsem">
              </div>
              <div class="col-12">
                <input class="d-block mx-auto func_btn p-3" type="submit" value="Hír közzététele" name="hirbtn">
              </div>
            </div>
          </form>
        </div>
        <hr>
        <?php } } ?>

        <?php
          $lekerdezes = "SELECT * FROM news ORDER BY postdate DESC";
          $talalt_hirek = $conn->query($lekerdezes);
          while($hir = $talalt_hirek->fetch_assoc()){
            if($hir['picture'] == ""){
        ?>
        <div class="container my-5 hirdiv rounded">
          <div class="row">
            <div class="col-12">
              <h3 class="text-center text-md-start"><?= htmlspecialchars_decode($hir['title']); ?></h3>
              <hr>
              <div class="d-none d-md-block">
                <p class="text-center">
                  <span class="text-start">Írta: <?=$hir['sender'];?></span>
                   | 
                  <span class="text-end"><?=$hir['postdate'];?></span>
                </p>
                <hr>
              </div>
              <p><?= htmlspecialchars_decode($hir['text']); ?></p>
              <div class="d-md-none">
                <p class="d-flex justify-content-between">
                  <span class="text-start">Írta: <?=$hir['sender'];?></span>
                  <span class="text-end"><?=$hir['postdate'];?></span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <?php }else{ ?>
        <div class="container my-5 hirdiv rounded">
          <div class="row">
            <div class="col-12 col-md-3 text-center">
              <img src="<?= $hir['picture']; ?>" alt="hirkep" class="h-100 img-fluid mx-auto d-md-block">
            </div>
            <div class="col-12 col-md-9">
              <hr class="d-block d-md-none">
              <h3 class="text-center text-md-start"><?= htmlspecialchars_decode($hir['title']); ?></h3>
              <hr>
              <div class="d-none d-md-block">
                <p class="text-center">
                  <span class="text-start">Írta: <?=$hir['sender'];?></span>
                   | 
                  <span class="text-end"><?=$hir['postdate'];?></span>
                </p>
                <hr>
              </div>
              <p><?= htmlspecialchars_decode($hir['text']); ?></p>
              <div class="d-md-none">
                <p class="d-flex justify-content-between">
                  <span class="text-start">Írta: <?=$hir['sender'];?></span>
                  <span class="text-end"><?=$hir['postdate'];?></span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <?php }} ?>

        <!-- Kép kiválasztása modal -->
        <div class="modal fade text-center" id="Kivalasztas" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">X</button>
                <hr class="mb-4">
                <input type="text" class="w-100" name="" id="keress" onkeyup="kerese()" placeholder="Anime neve...">
                <div class="container">
                  <div class="row d-block border p-0 m-0" id="result" style="height: 50vh !important; overflow-y: scroll;">
                
                  </div>
                </div>
                <p id="visszajelzes">Jelenleg nincsen kiválasztva kép.</p>
                <hr>
              </div>
            </div>
          </div>
        </div>

      </main>

      <footer class="hatternav text-center mt-3">
        © SandWitch - 2023
      </footer>

  </body>

  <script src="main.js"></script>
  <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>

</html>
<script>
  /* ---------- Hírek ajax-al ---------- */
  $('#result').load('hiranime.php');
  function kerese() {
    var k = document.getElementById("keress").value.replaceAll(" ","_");
    $('#result').load('hiranime.php?keresett='+k);
  }
  
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