<?php
  require "functions.php";
  $imhere = "modositas";
  $m = empty($_GET['modositando'])?"":$_GET['modositando'];
  if(!isset($_SESSION['modositando'])){
    $_SESSION['modositando'] = "";
  }
  if($m == "" && $_SESSION['modositando'] == ""){
    $anime = $conn->query("SELECT * FROM folista WHERE id=1");
  } else if($m == "" && $_SESSION['modositando'] != ""){
    $anime = $conn->query("SELECT * FROM $_SESSION[malname] WHERE id=$_SESSION[modositando]");
  }else {
    $anime = $conn->query("SELECT * FROM $_SESSION[malname] WHERE id=$m");
    $_SESSION['modositando'] = $m;
  }
  $a = $anime->fetch_assoc();

  if(isset($_POST['save_change_btn'])){
    $mid = $_GET['modositando'];
    $l = "UPDATE `$_SESSION[malname]` SET `score`='$_POST[score]',`state`='$_POST[state]',`episode1`='$_POST[episode]' WHERE id=$mid";
    $conn->query($l);
    $anime= $conn->query("SELECT * FROM `$_SESSION[malname]` WHERE id=$mid")->fetch_assoc();
    $status=str_replace(" ","_",$anime['state']);
    $acssestokne=$conn->query("SELECT * FROM Acsses_tokens WHERE Userid=$_SESSION[id]")->fetch_assoc();
    $url = "https://api.myanimelist.net/v2/anime/$anime[malid]/my_list_status";
    $data = [
      'status' => strtolower($status),
      'score' => $anime['score'],
      'num_watched_episodes' => $anime['episode1']
    ];

    $accessToken = $acssestokne['Token'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');//DELETE
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/x-www-form-urlencoded',
    ));
    $response = curl_exec($ch);

    /*---------- Hibakeresésre ----------*/
    /*
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_status >= 400) {
        echo "<script>alert('HTTP error: " . $http_status . "');</script>";
    } elseif (curl_errno($ch)) {
        echo "<script>alert('cURL error: " . curl_error($ch) . "');</script>";
    } else {
        echo "<script>alert('" . addslashes($response) . "');</script>";
    }
    */

    curl_close($ch);

    header("Location: modositas.php?modositas=$m");
  }

?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <?php include_once("metak.php"); ?>
    <?php include_once("linkek_css.php"); ?>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <title>YourAnimeList - Módosítás</title>
  </head>
  <body onload="Csillagom()">
      <header>
        <?php include_once("nav.php"); ?>
      </header>
      
      <main>
      <?php if(!empty($_SESSION['id'])){ ?>
        <h1 class="text-center">Anime részleteinek módosítása</h1>
        
        <div <?php if($_SESSION['modositando'] == "" ){ ?>class="d-none"<?php } ?>>
          <form action="modositas.php?modositando=<?=$a['id']?>" method="post">
            <div class="container modosit">
              <div class="row">
                <div class="col-md-6 col-12 p-0">
                  <img onerror="KepHiba(this)" src="<?=$a['picture']?>" class="rounded float-md-end d-block mx-auto h-100" alt="Anime kép" style="max-width: 300px; object-position: center;">
                </div>
                <div class="col-md-6 col-12 my-auto text-md-start text-center">
                  <p><label>Japán cím:</label> <?=$a['title_jpn']?></p>
                  <p><label>Angol cím:</label> <?=$a['title_eng']?></p>
                  <p><label>Típus:</label> <?=$a['type']?></p>
                  <p><label>Műfaj:</label> <?=$a['genres']?></p>
                  <p>
                    <label>Státusz:</label> 
                    <select name="state">
                      <option value="Watching"<?php if($a['state'] == 'Watching') { ?> selected <?php } ?>>Watching</option>
                      <option value="Completed"<?php if($a['state'] == 'Completed') { ?> selected <?php } ?>>Completed</option>
                      <option value="On Hold"<?php if($a['state'] == 'On Hold') { ?> selected <?php } ?>>On Hold</option>
                      <option value="Plan to Watch"<?php if($a['state'] == 'Plan to Watch') { ?> selected <?php } ?>>Plan to Watch</option>
                      <option value="Dropped"<?php if($a['state'] == 'Dropped') { ?> selected <?php } ?>>Dropped</option>
                    </select>
                  </p>
                  <p>
                    <label>Értékelés:</label> 
                    <select name="score" id="ertek" onchange="Csillagom()">
                      <option value="10" <?php echo ($a['score'] == 10) ? 'selected' : '';?>>10 - Mestermű</option>
                      <option value="9" <?php echo ($a['score'] == 9) ? 'selected' : '';?>>9 - Nagyszerű</option>
                      <option value="8" <?php echo ($a['score'] == 8) ? 'selected' : '';?>>8 - Nagyon jó</option>
                      <option value="7" <?php echo ($a['score'] == 7) ? 'selected' : '';?>>7 - Jó</option>
                      <option value="6" <?php echo ($a['score'] == 6) ? 'selected' : '';?>>6 - Korrekt</option>
                      <option value="5" <?php echo ($a['score'] == 5) ? 'selected' : '';?>>5 - Közepes</option>
                      <option value="4" <?php echo ($a['score'] == 4) ? 'selected' : '';?>>4 - Rossz</option>
                      <option value="3" <?php echo ($a['score'] == 3) ? 'selected' : '';?>>3 - Nagyon rossz</option>
                      <option value="2" <?php echo ($a['score'] == 2) ? 'selected' : '';?>>2 - Szörnyű</option>
                      <option value="1" <?php echo ($a['score'] == 1) ? 'selected' : '';?>>1 - Nézhetetlen</option>
                      <option value="0" <?php echo ($a['score'] == 0) ? 'selected' : '';?>>Még nem értékelem</option>
                    </select>
                    <br>
                    <span id="csillagok" class="text-warning"></span>
                  </p>
                  <p>
                    <label>Megtekintett epizódok:</label> 
                    <input type="number" name="episode" value="<?=$a['episode1']?>" min="0" max="<?=$a['episode2']?>"> / <?=$a['episode2']?>
                  </p>
                  <input type="submit" value="Módosítás mentése" name="save_change_btn" class="engedelyez_modosit">
                  <input type="reset" value="Mégsem" class="engedelyez_modosit">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="text-center <?php if($_SESSION['modositando'] != "" ) { ?>d-none<?php } ?>">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <img src="img/menhera_chan-waiting.gif" class="d-block mx-auto img-fluid" alt="Várakozás..." title="Válassz egy animét a lenti listából :D">
              </div>
            </div>
          </div>
          <h2>Még nem választott ki egy animét sem, amit módosítani szeretne.</h2>
        </div>
        <hr>

        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-10">
                  <input type="text" name="" onkeyup="kerese()" id="keress" class="w-100">
                </div>
                <div class="col-2">
                  <input type="button" value="Keresés" class="w-100">
                </div>
              </div>
            </div>
            <div class="col-12 border p-0 m-0" id="result" style="height: 50vh !important; overflow-y: scroll;">
              
            </div>
          </div>
        </div>
        <?php } ?>

        <?php if(empty($_SESSION['id'])) { ?>

          <div class="container jelentkezzbe">
            <div class="row">
              <div class="col-12 text-center">
                <img src="img/neo_alert.png" class="d-block mx-auto img-fluid" alt="Neo ALERT">
                <button onclick="location.href=`login.php`;">Irány a bejelentkezés</button>
              </div>
            </div>
          </div>

        <?php } ?>

      </main>

      <footer class="hatternav text-center mt-3">
        © SandWitch - 2023
      </footer>
  </body>

  <script src="main.js"></script>
  <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>
  <script>
    $('#result').load('minilista.php');
    function kerese() {
      var k = document.getElementById("keress").value.replaceAll(" ","_");
      $('#result').load('minilista.php?keresett='+k);
    }
  </script>
</html>