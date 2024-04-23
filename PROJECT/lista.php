<?php
  require "functions.php";
  $_SESSION['title']='';
  $_SESSION['lang']='title_jpn';
  $_SESSION['order']='title';
  $_SESSION['order_up_or_down']='ASC';
  if(isset($_POST['search-btn'])){
    $title=$_POST['anime_name'];
    $lang=$_POST['anime_nyelv'];
    $order=$_POST['order'];
    $order_up_down=$_POST['up_or_down'];
    //
    $_SESSION['title']=$_POST['anime_name'];
    $_SESSION['lang']=$_POST['anime_nyelv'];
    $_SESSION['order']=$_POST['order'];
    $_SESSION['order_up_or_down']=$_POST['up_or_down'];
    //
  }
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $title=$_POST['anime_name'];
    $lang=$_POST['anime_nyelv'];
    $order=$_POST['order'];
    $order_up_down=$_POST['up_or_down'];
    //
    $_SESSION['title']=$_POST['anime_name'];
    $_SESSION['lang']=$_POST['anime_nyelv'];
    $_SESSION['order']=$_POST['order'];
    $_SESSION['order_up_or_down']=$_POST['up_or_down'];
  }
  if(isset($_POST['update-btn'])){
   frissit();
  }
  //$aa = $conn->query("SELECT * FROM $_SESSION[malname] WHERE id = 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <?php include_once("metak.php"); ?>
    <?php include_once("linkek_css.php"); ?>
    <title>YourAnimeList - Lista</title>
  </head>
  <body>
      <header>
        <?php include_once("nav.php"); ?>
      </header>
      
      <main>
      <button type="button" class="btn btn-floating btn-lg border border-white" id="fel_gomb">
          <i class="fas fa-arrow-up"></i>
        </button>
        <?php if(!empty($_SESSION['id'])){ ?>

        <div id="kereses">
          <form action="lista.php" method="post" autocomplete="on">
            <div class="container">
              <div class="row">
                <div class="col-10">
                  <!--search bar history-->
                  <input class="w-100" type="text" name="anime_name" value="<?php if (!empty($_SESSION['title'])) {echo $_SESSION['title'];}?>" placeholder="Anime neve..." /*required="required"*/>
                  <!---->
                </div>
                <div class="col-2">
                  <input class="btn btn-block float-end px-5" type="submit" value="&nbsp;" name="search-btn" id="searchbtn">
                </div>
                <div class="col-12 text-center">
                  Lista frissítése &nbsp;
                  <input class="btn btn-block px-5 updatebtn" type="submit" value="&nbsp;" name="update-btn" id="updatebtn">
                </div>
              </div>
            </div>
            <div class="container text-center">
              <div class="row mb-3">
                <p>Melyik nyelven szeretnél keresni?</p>
                <div class="col-12 text-center">
                  <!--lang history-->
                  <input type="radio" name="anime_nyelv" value="title_jpn" <?php if ($_SESSION['lang']=='title_jpn') {echo'checked';}?> onchange="this.form.submit()">
                  <label>Japán cím</label>
                  <input type="radio" name="anime_nyelv" value="title_eng"<?php if ($_SESSION['lang']=='title_eng') {echo'checked';}?> onchange="this.form.submit()">
                  <label>Angol cím</label>
                  <!---->
                </div>
              </div>
              <div class="row text-center">
                <div class="col-12">
                  <label>Rendezés: </label>
                  <select name="order" onchange="this.form.submit()">
                    <!--order history-->
                    <option value="title" <?php if ($_SESSION['order']=='title') {echo'selected';}?> >Cím</option>
                    <option value="score" <?php if ($_SESSION['order']=='score') {echo'selected';}?> >Értékelés</option>
                    <option value="type" <?php if ($_SESSION['order']=='type') {echo'selected';}?> >Típus</option>
                    <!---->
                  </select>
                  <select name="up_or_down" onchange="this.form.submit()">
                    <!--up_or_down history-->
                    <option value="ASC" <?php if ($_SESSION['order_up_or_down']=='ASC') {echo'selected';}?> >Növekvő</option>
                    <option value="DESC" <?php if ($_SESSION['order_up_or_down']=='DESC') {echo'selected';}?> >Csökkenő</option>
                    <!---->
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <hr>
        <p class="text-center"><i class="fa-solid fa-circle-info text-primary"></i> Kattints a képekre több infóért!</p>
        <p class="text-center"><i class="fa-solid fa-circle-question text-warning"></i> <a href="#" data-bs-toggle="modal" data-bs-target="#MitJelent">Mit jelent a TV, ONA, stb.?</a></p>

<!-- Infó modal -->
<div class="modal fade text-center" id="MitJelent" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">X</button>
        <hr class="mb-4">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                TV (Television Series)
              </button>
            </h2><!-- strong / code -> tagek -->
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body bg-dark">
                Ez az "anime sorozat" rövidítése. A legtöbb anime ebben a formátumban készül, és rendszerint hetente sugározzák a televízióban. Az epizódok száma változhat, néhány sorozat csak 12 vagy 24 részből áll, míg mások több száz epizódot is tartalmazhatnak.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                OVA (Original Video Animation)
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Olyan animesorozatok vagy epizódok, amelyek nem kerülnek a televízióba sugárzásra, hanem közvetlenül DVD-re vagy Blu-ray-re készülnek. Az OVA-k gyakran extra tartalmat vagy kiegészítő részeket tartalmaznak egy már meglévő sorozathoz, de néha önálló történetek is lehetnek.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                OAD (Original Animation DVD)
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Ez a kifejezés hasonló az OVA-hoz, de általában kizárólag egy meglévő manga sorozathoz készül. Az OAD-ket gyakran a manga kötetekhez csatolják az előrendelt változatokhoz vagy más speciális kiadásokhoz.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFive">
                ONA (Original Net Animation)
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Olyan anime sorozatok vagy epizódok, amelyek eredetileg az interneten keresztül kerülnek terjesztésre. Ezeket gyakran online platformokon, streaming szolgáltatásokon keresztül teszik elérhetővé.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Movie (Film)
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Az anime filmek, mint a hagyományos filmek, hosszabb időtartamra és nagyobb költségvetésre épülnek. Ezek lehetnek új történetek, adaptációk meglévő sorozatokból vagy önálló alkotások. Az anime filmek gyakran bemutatkoznak a mozikban, majd később elérhetők lehetnek otthoni megtekintésre.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingSix">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                Special
              </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                A "special" (speciális) jelző olyan tartalmakat takar, amelyek nem illeszkednek a sorozat rendes epizódjaihoz vagy a filmekhez. Ez lehet például egy különleges epizód, egy extra rész, amely nem szerepel a rendes epizódszámok között.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingSeven">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                Spin-off
              </button>
            </h2>
            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Egy olyan mű, amely egy meglévő anime vagy manga univerzumán belül jön létre, de különálló történetet vagy karaktereket mutat be. Például egy mellékszereplő lehet a főszereplővé válik.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingEight">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                Recap
              </button>
            </h2>
            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                A recap epizódok olyan részek vagy epizódok, amelyek összefoglalják az előző eseményeket. Általában azért készülnek, hogy az új nézők könnyebben bekapcsolódhassanak, vagy hogy a már meglévő rajongók emlékezhessenek az eseményekre. Ezek a részek gyakran előfordulnak hosszabb anime sorozatokban.
              </div>
            </div>
          </div>
          <div class="accordion-item bg-dark m-2">
            <h2 class="accordion-header" id="headingNine">
              <button class="accordion-button bg-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                Crossover
              </button>
            </h2>
            <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Olyan mű, amely két vagy több különböző anime, manga vagy média univerzumot összekapcsol, általában egy közös eseményben vagy történetben.
              </div>
            </div>
          </div>
        </div>
        <hr>
      </div>
    </div>
  </div>
</div>

        <div class="container">
          <div class="row">
            <?php
            if ( $_SESSION['order']=='title') {
              $lekerdezes = "SELECT * FROM $_SESSION[malname] INNER JOIN statusorder ON $_SESSION[malname].state = statusorder.so_state WHERE $_SESSION[malname].$_SESSION[lang] LIKE '%$_SESSION[title]%' ORDER BY statusorder.so_number ASC, $_SESSION[malname].$_SESSION[lang]  $_SESSION[order_up_or_down]";
            }
            elseif ( $_SESSION['order']=='score') {
              $lekerdezes = "SELECT * FROM $_SESSION[malname] INNER JOIN statusorder ON $_SESSION[malname].state = statusorder.so_state WHERE $_SESSION[malname].$_SESSION[lang] LIKE '%$_SESSION[title]%' ORDER BY statusorder.so_number ASC, $_SESSION[malname].$_SESSION[order]  $_SESSION[order_up_or_down]";
            }
            elseif ( $_SESSION['order']=='type') {
              $lekerdezes = "SELECT * FROM $_SESSION[malname] INNER JOIN statusorder ON $_SESSION[malname].state = statusorder.so_state WHERE $_SESSION[malname].$_SESSION[lang] LIKE '%$_SESSION[title]%' ORDER BY statusorder.so_number ASC, $_SESSION[malname]. $_SESSION[order] $_SESSION[order_up_or_down]";
            }
            //empty search bar handeling
            /*elseif (empty($title)) {
              $lekerdezes = "SELECT * FROM $_SESSION[malname] INNER JOIN statusorder ON $_SESSION[malname].state = statusorder.so_state ORDER BY statusorder.so_number ASC, $_SESSION[malname].$lang $order_up_down";
            }*/
              $osszes = $conn->query($lekerdezes);
              $tempid = 0;
              if (mysqli_num_rows($osszes)==0) {
                echo "<SCRIPT>alert('Nincs ilyen anime a listádon')</SCRIPT>";
                if ( $_SESSION['order']=='title') {
                  $lekerdezes = "SELECT * FROM $_SESSION[malname] INNER JOIN statusorder ON $_SESSION[malname].state = statusorder.so_state ORDER BY statusorder.so_number ASC, $_SESSION[malname].$_SESSION[lang] ".$_SESSION['order_up_or_down']."";
                }
                elseif ( $_SESSION['order']=='score') {
                  $lekerdezes = "SELECT * FROM $_SESSION[malname] INNER JOIN statusorder ON $_SESSION[malname].state = statusorder.so_state ORDER BY statusorder.so_number ASC, $_SESSION[malname].$_SESSION[order] ".$_SESSION['order_up_or_down']."";
                }
                elseif ( $_SESSION['order']=='type') {
                  $lekerdezes = "SELECT * FROM $_SESSION[malname] INNER JOIN statusorder ON $_SESSION[malname].state = statusorder.so_state ORDER BY statusorder.so_number ASC, $_SESSION[malname]. $_SESSION[order]".$_SESSION['order_up_or_down']."";
                }
                $osszes = $conn->query($lekerdezes);
              }
              while($anime=$osszes->fetch_assoc()){
                $tempid++;
            ?>
            <div class=" animated tada col-lg-2 col-md-3 col-sm-4 col-6 p-0">
              <div  class=" anime_doboz mx-2 my-2 <?php echo StatusZ($anime); ?> ">
              <img src="<?=$anime['picture'];?>" alt="anime kép" class="mx-auto d-block w-100 anime_kep" data-bs-toggle="modal" data-bs-target="#ablak" title="Katt több infóért!" onclick="AnimeAblakok(<?=$anime['id'];?>)">
                <div class="grid-container">
                  <div class="anime_szoveg grid-item">
                      <p class="m-0 anime_fontos"><?=$anime[$_SESSION['lang']];?></p>
                      <div class="row anime_mellekes">
                        <div class="col-6">
                          <span class="text-info"><?=$anime['type']?></span>
                        </div>
                        <div class="col-6 text-end">
                          <span class="text-end"><?=$anime['score'];?> <i class="<?php echo CsillagFajta($anime); ?> text-warning"></i></span>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } }?>
          </div>
        </div>

        <?php
          if(!empty($_SESSION['id'])){
        ?>
          <!-- Felugró ablak több infóval az animéről -->
          <div class="modal fade text-center" id="ablak" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" id="AnimeAblak">
                
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if(empty($_SESSION['id'])) { ?>
          <!-- Ha nincsen bejelentkezve -->
          <div class="container jelentkezzbe">
            <div class="row">
              <div class="col-12 text-center">
                <img src="img/neo_alert.png" class="d-block mx-auto img-fluid" alt="Neo ALERT">
                <button onclick="location.href=`login.php`;" class="func_btn p-2">Irány a bejelentkezés</button>
              </div>
            </div>
          </div>

        <?php } ?>

      </main>

      <footer class="hatternav text-center mt-3">
        © SandWitch - 2023-2024
      </footer>

  </body>

  <script src="main.js"></script>
  <script src="felgomb.js"></script>
  <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>
  <script src="https://code.jquery.com/jquery-latest.js"></script>
</html>
<script>
    function AnimeAblakok(n){
      $("#AnimeAblak").load("animeablak.php?aa="+n);
    }
</script>
