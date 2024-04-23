<?php
require "functions.php";
$kapott = $_GET['aa'];
$aa = $conn->query("SELECT * FROM $_SESSION[malname] WHERE id = $kapott")->fetch_assoc();
$genres_array = explode(", ",$aa['genres']);
?>
<head>
    <?php include_once("linkek_css.php"); ?>
</head>
<div class="modal-body text-center"> 
<button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">X</button>
<hr class="mb-4">
<img src="<?=$aa['picture'];?>" alt="kép helye" class="d-block mx-auto">
<?php echo Nevek($aa); ?>
<p>Értékelés:<br><?php echo Ertekeles($aa); ?></p>
<p>
  Műfaj: 
  <?php
      for ($i = 0; $i < count($genres_array); $i++) {
          echo "<div class='mufajok m-1'>$genres_array[$i]</div>";
          if($i < count($genres_array))
              echo " ";
      }
  ?>
</p>
<p>Státusz: <?=$aa['state'];?></p>
<p>Megtekintett epizódok: <?=$aa['episode1'];?>/<?=$aa['episode2'];?></p>
<hr>
<button onclick="location.href='modositas.php?modositando=<?=$aa['id']?>'" type="button" class="d-block mx-auto">Módosítás</button>
</div>
<style>
  .modal-content {
    background-color: pink !important;
  }
</style>