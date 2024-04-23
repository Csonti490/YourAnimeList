<?php
  require "functions.php";
  $imhere = "statisztika";
?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <?php include_once("metak.php"); ?>
    <?php include_once("linkek_css.php"); ?>
    <title>YourAnimeList - Statisztika</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  </head>
  <body>

      <header>
        <?php include_once("nav.php"); ?>
      </header>
      
      <main>

        <?php if(!empty($_SESSION['id'])){ ?>
        <h1 class="text-center my-3">Statisztika</h1>
        <div class="container p-0" id="elso">
            <div class="row m-0 p-0">
              <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb">
                <button class="w-100" onclick="Valtas(1)" disabled>Alap statisztikák</button>
                <button class="w-100" onclick="Valtas(2)">Megnézett/Megnézendő</button>
                <button class="w-100" onclick="Valtas(3)">Adott értékelések</button>
              </div>
            </div>
            <div class="row m-0 p-0">
              <div class="col-12 border border-1">
                <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
              </div>
            </div>
            <div class="row m-0 p-0">
              <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb2">
                <button class="w-100 slidebtn" onclick="Valtas(1)" disabled>Letett</button>
                <button class="w-100 slidebtn" onclick="Valtas(12)">Szüneteltetett</button>
                <button class="w-100 slidebtn" onclick="Valtas(13)">Épp nézi</button>
              </div>
          </div>
        </div>
        
        <div class="container p-0" id="elso2">
          <div class="row m-0 p-0">
            <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb">
              <button class="w-100" onclick="Valtas(1)" disabled>Alap statisztikák</button>
              <button class="w-100" onclick="Valtas(2)">Megnézett/Megnézendő</button>
              <button class="w-100" onclick="Valtas(3)">Adott értékelések</button>
            </div>
          </div>
          <div class="row m-0 p-0">
            <div class="col-12 border border-1">
              <div id="chartContainer12" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
          <div class="row m-0 p-0">
            <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb2">
            <button class="w-100 slidebtn" onclick="Valtas(1)">Letett</button>
                <button class="w-100 slidebtn" onclick="Valtas(12)" disabled>Szüneteltetett</button>
                <button class="w-100 slidebtn" onclick="Valtas(13)">Épp nézi</button>
            </div>
          </div>
        </div>

        <div class="container p-0" id="elso3">
          <div class="row m-0 p-0">
            <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb">
              <button class="w-100" onclick="Valtas(1)" disabled>Alap statisztikák</button>
              <button class="w-100" onclick="Valtas(2)">Megnézett/Megnézendő</button>
              <button class="w-100" onclick="Valtas(3)">Adott értékelések</button>
            </div>
          </div>
          <div class="row m-0 p-0">
            <div class="col-12 border border-1">
              <div id="chartContainer13" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
          <div class="row m-0 p-0">
            <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb2">
            <button class="w-100 slidebtn" onclick="Valtas(1)">Letett</button>
                <button class="w-100 slidebtn" onclick="Valtas(12)">Szüneteltetett</button>
                <button class="w-100 slidebtn" onclick="Valtas(13)" disabled>Épp nézi</button>
            </div>
          </div>
        </div>

        <div class="container p-0" id="masodik">
          <div class="row m-0 p-0">
            <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb">
              <button class="w-100" onclick="Valtas(1)">Alap statisztikák</button>
              <button class="w-100" onclick="Valtas(2)" disabled>Megnézett/Megnézendő</button>
              <button class="w-100" onclick="Valtas(3)">Adott értékelések</button>
            </div>
          </div>
          <div class="row m-0 p-0">
            <div class="col-12 border border-1">
              <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
          <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb2">
              <button class="w-100 slidebtn" onclick="Valtas(2)" disabled>Megnézett</button>
              <button class="w-100 slidebtn" onclick="Valtas(22)">Megnézendő</button>
          </div>
        </div>

        <div class="container p-0" id="masodik2">
          <div class="row m-0 p-0">
            <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb">
              <button class="w-100" onclick="Valtas(1)">Alap statisztikák</button>
              <button class="w-100" onclick="Valtas(2)" disabled>Megnézett/Megnézendő</button>
              <button class="w-100" onclick="Valtas(3)">Adott értékelések</button>
            </div>
          </div>
          <div class="row m-0 p-0">
            <div class="col-12 border border-1">
              <div id="chartContainer22" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
          <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb2">
              <button class="w-100 slidebtn" onclick="Valtas(2)">Megnézett</button>
              <button class="w-100 slidebtn" onclick="Valtas(22)" disabled>Megnézendő</button>
          </div>
        </div>

        <div class="container p-0" id="harmadik">
          <div class="row m-0 p-0">
            <div class="col-12 m-0 p-0 d-flex justify-content-between stat_gomb">
              <button class="w-100" onclick="Valtas(1)">Alap statisztikák</button>
              <button class="w-100" onclick="Valtas(2)">Megnézett/Megnézendő</button>
              <button class="w-100" onclick="Valtas(3)" disabled>Adott értékelések</button>
            </div>
          </div>
          <div class="row m-0 p-0">
            <div class="col-12 border border-1">
              <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
        </div>

        <?php } ?>

        <?php if(empty($_SESSION['id'])) { ?>

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
  <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</html>
<script>
var elso = document.getElementById("elso");
var elso2 = document.getElementById("elso2");
var elso3 = document.getElementById("elso3");
var masodik = document.getElementById("masodik");
var masodik2 = document.getElementById("masodik2");
var harmadik = document.getElementById("harmadik");

const btns1 = document.getElementsByClassName("slidebtn");

elso2.style.display = "none";
elso3.style.display = "none";
masodik.style.display = "none";
masodik2.style.display = "none";
harmadik.style.display = "none";

function Valtas(n){
    switch(n) {
        case 1:
            elso.style.display="block";
            elso2.style.display = "none";
            elso3.style.display = "none";
            masodik.style.display="none";
            masodik2.style.display="none";
            harmadik.style.display="none";
            window.dispatchEvent(new Event('resize'));
            break;
        case 12:
            elso.style.display="none";
            elso2.style.display = "block";
            elso3.style.display = "none";
            masodik.style.display = "none";
            masodik2.style.display="none";
            harmadik.style.display = "none";
            window.dispatchEvent(new Event('resize'));
            break;
        case 13:
            elso.style.display="none";
            elso2.style.display = "none";
            elso3.style.display = "block";
            masodik.style.display = "none";
            masodik2.style.display="none";
            harmadik.style.display = "none";
            window.dispatchEvent(new Event('resize'));
            break;
        case 2:            
            elso.style.display="none";
            elso2.style.display = "none";
            elso3.style.display = "none";
            masodik.style.display="block";
            masodik2.style.display="none";
            harmadik.style.display="none";
            window.dispatchEvent(new Event('resize'));
            break;
        case 22:            
            elso.style.display="none";
            elso2.style.display = "none";
            elso3.style.display = "none";
            masodik.style.display="none";
            masodik2.style.display="block";
            harmadik.style.display="none";
            window.dispatchEvent(new Event('resize'));
            break;
        case 3:
            elso.style.display="none";
            elso2.style.display = "none";
            elso3.style.display = "none";
            masodik.style.display="none";
            masodik2.style.display="none";
            harmadik.style.display="block";
            window.dispatchEvent(new Event('resize'));
            break;
        default:
            elso.style.display="block";
            masodik.style.display="none";
            masodik2.style.display="none";
            harmadik.style.display="none";
            elso2.style.display = "none";
            elso3.style.display = "none";
    }
}

//Charts

window.onload = function () {

  //DroppedChart

  var chart1 = new CanvasJS.Chart("chartContainer1", {
      animationEnabled: true,
      backgroundColor: "",
      toolTip:{
          enabled: false
      },
      data: [{
          type: "doughnut",
          startAngle: 60,
          indexLabelFontColor: "white",
          //innerRadius: 60,
          indexLabelFontSize: 17,
          indexLabel: "{label} - #percent%",
          toolTipContent: "<b>{label}:</b> {y} (#percent%)",
          dataPoints: [
              <?php
          $lekerdezes = "SELECT * FROM $_SESSION[malname] WHERE state = 'Dropped'";
          $talalt_dropped = $conn->query($lekerdezes);
          
          $genlist = array();
          $droppeds = array();
          while ($n = $talalt_dropped->fetch_assoc()) {
              foreach(explode(", ", $n['genres']) as $gensplit){
                  array_push($genlist, $gensplit);
              }
          }
          
          foreach($genlist as $gen){
              if(array_key_exists($gen, $droppeds)){
                  $droppeds[$gen] = $droppeds[$gen] + 1;
              }
              else{
                  $droppeds[$gen] = 1;
              }                          
          }
          
          while($element = current($droppeds)) {
              echo "{ y: ".$element.", label: '".key($droppeds)."' },";
              next($droppeds);
          }
          ?>
          ]
      }]
  });
  chart1.render();  


  var chart12 = new CanvasJS.Chart("chartContainer12", {
      animationEnabled: true,
      backgroundColor: "",
      toolTip:{
          enabled: false
      },
      data: [{
          type: "doughnut",
          startAngle: 60,
          indexLabelFontColor: "white",
          //innerRadius: 60,
          indexLabelFontSize: 17,
          indexLabel: "{label} - #percent%",
          toolTipContent: "<b>{label}:</b> {y} (#percent%)",
          dataPoints: [
              <?php
          $lekerdezes = "SELECT * FROM $_SESSION[malname] WHERE state = 'On Hold'";
          $talalt_dropped = $conn->query($lekerdezes);
          
          $genlist = array();
          $droppeds = array();
          while ($n = $talalt_dropped->fetch_assoc()) {
              foreach(explode(", ", $n['genres']) as $gensplit){
                  array_push($genlist, $gensplit);
              }
          }
          
          foreach($genlist as $gen){
              if(array_key_exists($gen, $droppeds)){
                  $droppeds[$gen] = $droppeds[$gen] + 1;
              }
              else{
                  $droppeds[$gen] = 1;
              }                          
          }
          
          while($element = current($droppeds)) {
              echo "{ y: ".$element.", label: '".key($droppeds)."' },";
              next($droppeds);
          }
          ?>
          ]
      }]
  });
  chart12.render();  

  var chart13 = new CanvasJS.Chart("chartContainer13", {
      animationEnabled: true,
      backgroundColor: "",
      toolTip:{
          enabled: false
      },
      data: [{
          type: "doughnut",
          startAngle: 60,
          indexLabelFontColor: "white",
          //innerRadius: 60,
          indexLabelFontSize: 17,
          indexLabel: "{label} - #percent%",
          toolTipContent: "<b>{label}:</b> {y} (#percent%)",
          dataPoints: [
              <?php
          $lekerdezes = "SELECT * FROM $_SESSION[malname] WHERE state = 'Watching'";
          $talalt_dropped = $conn->query($lekerdezes);
          
          $genlist = array();
          $droppeds = array();
          while ($n = $talalt_dropped->fetch_assoc()) {
              foreach(explode(", ", $n['genres']) as $gensplit){
                  array_push($genlist, $gensplit);
              }
          }
          
          foreach($genlist as $gen){
              if(array_key_exists($gen, $droppeds)){
                  $droppeds[$gen] = $droppeds[$gen] + 1;
              }
              else{
                  $droppeds[$gen] = 1;
              }                          
          }
          
          while($element = current($droppeds)) {
              echo "{ y: ".$element.", label: '".key($droppeds)."' },";
              next($droppeds);
          }
          ?>
          ]
      }]
  });
  chart13.render();  

  //Spline

  var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,  
    backgroundColor: "",
    height:370,
    axisY: {
      title: "Anime",
      labelFontColor: "white",
      titleFontColor: "#white",
    },
    axisX: {
      labelFontColor: "white",
      titleFontColor: "#white",
      <?php 
        $lekerdezes = "SELECT * FROM $_SESSION[malname] WHERE state = 'Completed'";
        $talalt_comp = $conn->query($lekerdezes);

        $genlist = array();
        $comps = array();
        while ($n = $talalt_comp->fetch_assoc()) {
            foreach(explode(", ", $n['genres']) as $gensplit){
                array_push($genlist, $gensplit);
            }
        }
        
        foreach($genlist as $gen){
            if(array_key_exists($gen, $comps)){
                $comps[$gen] = $comps[$gen] + 1;
            }
            else{
                $comps[$gen] = 1;
            }                          
        }

        if(sizeof($comps) < 20){
      ?>
      interval: 1
      <?php }else{ ?>
      interval: 2
      <?php } ?>
    },
    data: [{
      yValueFormatString: "#,### Units",
      xValueFormatString: "YYYY",
      type: "spline",
      dataPoints: [
        <?php                                              
            while($element = current($comps)) {
                echo "{ y: ".$element.", label: '".key($comps)."' },";
                next($comps);
            }
            ?>		
      ]
    }]
  });
  chart2.render();


  var chart22 = new CanvasJS.Chart("chartContainer22", {
    animationEnabled: true,  
    backgroundColor: "",
    height:370,
    axisY: {
      title: "Anime",
      labelFontColor: "white",
      titleFontColor: "#white",
    },
    axisX: {
      labelFontColor: "white",
      titleFontColor: "#white",
      <?php 
        $lekerdezes = "SELECT * FROM $_SESSION[malname] WHERE state = 'Plan to Watch'";
        $talalt_comp = $conn->query($lekerdezes);

        $genlist = array();
        $comps = array();
        while ($n = $talalt_comp->fetch_assoc()) {
            foreach(explode(", ", $n['genres']) as $gensplit){
                array_push($genlist, $gensplit);
            }
        }
        
        foreach($genlist as $gen){
            if(array_key_exists($gen, $comps)){
                $comps[$gen] = $comps[$gen] + 1;
            }
            else{
                $comps[$gen] = 1;
            }                          
        }
            

        if(sizeof($comps) < 20){
      ?>
      interval: 1
      <?php }else{ ?>
      interval: 2
      <?php } ?>
    },
    data: [{
      yValueFormatString: "#,### Units",
      xValueFormatString: "YYYY",
      type: "spline",
      dataPoints: [
        <?php                                    
            while($element = current($comps)) {
                echo "{ y: ".$element.", label: '".key($comps)."' },";
                next($comps);
            }
            ?>		
      ]
    }]
  });
  chart22.render();


  var chart3 = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
  backgroundColor: "",
  height:370,
	axisX: {
		labelFontColor: "white",
    titleFontColor: "#white",
    interval: 1
	},
	axisY: {
		title: "Scores",
    labelFontColor: "white",
    titleFontColor: "#white",
	},
	data: [{
		indexLabelFontColor: "darkSlateGray",
		type: "area",
    color: "rgb(87, 31, 105)",
		yValueFormatString: "#,##0db",
		dataPoints: [
			<?php
        $lekerdezes = "SELECT * FROM $_SESSION[malname] WHERE score > 0";
        $talalt_scores = $conn->query($lekerdezes);
        
        $scores = array();

        for ($i=1; $i < 11; $i++) { 
          $scores[$i] = 0;
        }

        while ($n = $talalt_scores->fetch_assoc()) {
          if(array_key_exists($n['score'], $scores)){
              $scores[$n['score']] = $scores[$n['score']] + 1;
          }
          else{
              $scores[$n['score']] = 1;
          }   
        }
        
        for ($i=1; $i < 11; $i++) { 
          echo "{ y: ".$scores[$i].", label: '".$i."' },";
        }
      ?>		
		]
	}]
});
chart3.render();


}

</script>