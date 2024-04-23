<?php
    require "functions.php";

?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
    <head>
        <?php include_once("metak.php"); ?>
        <!-- Logo -->
        <link rel="icon" type="image/x-icon" href="img/YourAnimeList_Logo2.png">
        <!-- Formázások fájlainak behívása -->
        <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.css">
        <!--<link rel="stylesheet" href="style.css" type="text/css">-->
        <!-- Ikonok behívása -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <!-- AJAX -->
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <title>YourAnimeList - Profil</title>
    </head>
    <body>

        <main>
            <!-- Modal tartalom -->
            <div id="myModal" class="modal">
            <div class="modal-content">
                <p>Modal tartalom</p>
            </div>
            </div>

            <form action="tesztelek2.php" method="post">
                <input type="hidden" name="kep" id="kep" value="">
                <input type="button" value="Gomb 1" onclick="setAdditionalDataAndSubmit('valami_adat')">
                <input type="button" value="Gomb 2" onclick="setAdditionalDataAndSubmit('másik_adat')">
                <input type="submit" value="Elküld">
            </form>

<script>
function setAdditionalDataAndSubmit(data) {
    document.getElementById('kep').value = data;
}
</script>


            <script>
            
            </script>
        </main>
    </body>
    <!--<script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>-->
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>

</html>


<style>
    /*---------- SZÍNEK ----------*/
:root {
    --vilagoslila: rgb(138, 79, 255);
    --zoldeskek: rgb(0, 109, 119);
    --sotetzold: rgb(0, 60, 60);
    --vilagoskek: rgb(37, 183, 250);
    --sotetlila: rgb(87, 31, 105);
    --sotetkek2: rgb(29,35,49);
    --sotetkek: rgb(28,37,63);
    --szurke: rgb(43, 42, 51);
    --vilagosszurke: rgb(66, 64, 73);
    --feherlila: rgb(179, 154, 187);

    --szin1: rgb(22,30,50); /* hatter */
    --szin2: rgb(70,25,84); /* fejlec,lablec */
    --szin3: rgb(11,15,25); /* ajanlo */
    --szin4: rgb(35,38,39); /* szurke regist/login */
}
* {
    box-sizing: border-box !important;
}
body {
    background-color: var(--sotetkek);
    color: white;
}
main {
    margin: 0 !important;
    padding: 0 !important;
}
</style>
<style>
/* Modal stílusok */
.modal {
  display: none; /* Alapértelmezés szerint rejtve */
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* Animáció */
@keyframes fadeInOut {
  0%, 100% { opacity: 0; }
  50% { opacity: 1; }
}
</style>

<form action="tesztelek2.php" method="post">
                
                <input type="button" value="Gomb 1" onclick="setAdditionalDataAndSubmit('valami_adat')">
                <input type="button" value="Gomb 2" onclick="setAdditionalDataAndSubmit('másik_adat')">
                <input type="submit" value="Elküld">
            </form>

<script>
function setAdditionalDataAndSubmit(data) {
    document.getElementById('kep').value = data;
}
</script>