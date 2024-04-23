<nav class="navbar navbar-expand-md navbar-dark hatternav">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" style="padding: 8px 0 !important;"><img src="img/YourAnimeList_title2.png" title="YourAnimeList" alt="Logo" class="d-block"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link" href="hirfolyam.php"><i class="fa-solid fa-newspaper"></i> Hírfolyam</a><!--Lista(Egész Adatbázis), Keresés-->
        </li>
        <li class="nav-item">
          <a class="nav-link" href="lista.php"><i class="fa-solid fa-arrow-down-a-z"></i> Lista</a><!--Lista(Egész Adatbázis), Keresés-->
        </li>
        <li class="nav-item">
          <a class="nav-link" href="statisztika.php"><i class="fa-solid fa-clipboard-list"></i> Statisztika</a><!--Statisztika, Ajánlás(Ezeket még nem láttad)-->
        </li>
        <li class="nav-item">
          <a class="nav-link" href="modositas.php"><i class="fa-solid fa-pen-to-square"></i> Módosít</a><!--Hozzáad, Töröl (küld ért. Hf.)-->
        </li>
        <?php if(empty($_SESSION['id'])){ ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Bejelentkezés</a>
          </li>
        <?php } ?>
        <?php if(!empty($_SESSION['id'])){ ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user"></i> Profil
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="uzenet.php"><i class="fa-regular fa-message"></i> Üzeneteid</a></li><!--Ez még nem fix-->
              <li><a class="dropdown-item" href="profil.php"><i class="fa-solid fa-gear"></i> Beállítások</a></li><!--A profil beállításai-->
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#kilepModal"><i class="fa-solid fa-arrow-right-from-bracket"></i> Kijelentkezés</a></li>
            </ul>
          </li>
        <?php if ($_SESSION['rank']=='admin') {
           echo'<li class="nav-item">
           <a class="nav-link" href="admin.php"><i class="fa-solid fa-screwdriver-wrench"></i> Admin Felület</a>
         </li>';
        }
        elseif ($_SESSION['rank']!='admin') {
          echo'<li class="nav-item">
          <a class="nav-link" href="admin_keres.php"><i class="fa-solid fa-circle-question"></i> Admin Segít</a>
        </li>';
        }?>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<!--Kijelentkezés felugró ablaka-->
<div class="modal fade" id="kilepModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 id="felugro_szoveg" class="modal-title w-100">Biztos, hogy kilépsz?</h4>
      </div>
      <div class="modal-body text-center">
        <img src="img/aqua_angry.png" alt="Kijelentkezés képe" id="felugro_kep">
      </div>
      <div class="modal-footer">
        <div class="container-fluid text-center">
          <div class="row">
            <div class="col-6">
              <form method="post" action="index.php">
                <input type="submit" class="btn btn-success" value="Kijelentkezés" name="logout_btn" onMouseOver="KepCsere(1)" onMouseOut="KepCsere(0)">
              </form>
            </div>
            <div class="col-6">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onMouseOver="KepCsere(2)" onMouseOut="KepCsere(0)">Mégsem</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Cookie modal -->
<?php if(!isset($_COOKIE["yalcookie"])) { ?>
  <div class="position-fixed bottom-0 m-3" style="z-index: 1 !important;" id="yalc">
    <div class="border border-secondary rounded p-3" style="width: 250px; background-color: rgba(43, 42, 51, 0.95);">
      <p class="text-center p-0 m-0">Ez a weboldal cookie-kat használ annak érdekében, hogy a webhelyünk jobb élményt nyújthasson.</p>
      <img src="img/rwby-cookie2.png" class="d-block mx-auto w-75 my-3">
        <button onclick="Magic()"class="d-block mx-auto btn btn-success">Elfogadom</button> 
    </div>
  </div>
<?php } ?>
