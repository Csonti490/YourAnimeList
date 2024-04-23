<?php
    require "functions.php";
    $imhere = "profil";
    $s=explode("_",$_SESSION['malname']);
    if(isset($_POST['valtoztat_btn'])){
        Valtoztat($_POST['']);
    }
    if(isset($_POST['delete_btn'])){
        //messages
        //friends_list
        $conn->query("DELETE FROM messages WHERE conversation_id=".$conn->query("SELECT * FROM conversations WHERE sender_id=$_SESSION[id] OR adressed_id=$_SESSION[id]")->fetch_assoc()['id']."");
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
        $conn->query("DELETE FROM `admin_uzenetek` WHERE felado = $_SESSION[id]");
        $conn->query("DROP TABLE `$_SESSION[malname]`");
        $conn->query("DELETE FROM `users` WHERE id = $_SESSION[id]");
    }
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
    <head>
        <?php include_once("metak.php"); ?>
        <?php include_once("linkek_css.php"); ?>
        <script src="https://code.jquery.com/jquery-latest.js"></script>
        <title>YourAnimeList - Profil</title>
    </head>
    <body>

        <header>
            <?php include_once("nav.php"); ?>
        </header>

        <main>

            <?php 
                $lekerdezes = "SELECT * FROM $_SESSION[malname]";
                $animelista = $conn->query($lekerdezes);
                $lista_hossza = $animelista->num_rows;
            ?>
            
            <h1 class="text-center" id="cim">Profil információk</h1>

            <!-- Alap felület -->
            <div class="container" id="profil_alap">
                <div class="row my-3">
                    <div class="col-sm-6 col-12 p-0 overflow-hidden">
                        <img src="<?php echo"".$_SESSION['img'].""; ?>" alt="profilkép" class="rounded float-md-end d-block mx-auto" style="max-width: 225px; max-height: 318px;">
                    </div>
                    <div class="col-sm-6 col-12 my-auto text-sm-start text-center"><!-- justify-content-sm-end -->
                        <p>Felhasználónév:<br><strong><?= $_SESSION['name']; ?></strong></p>
                        <p> MAL listád neve:<br><strong><?= $s[1]; ?></strong></p>
                        <p>Rangod:<br><strong><?= $_SESSION['rank']; ?></strong></p>
                        <p>A listád <strong><?= $lista_hossza ?></strong> db animét tartalmaz.</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <button onclick="ProfilModosit(1)" class="func_btn">Profil módosítása</button>
                    </div>
                </div>
            </div>

            <!-- Módosító felület -->
            <div class="container d-none" id="profil_modosit">
                <form method="post" action="profil.php">
                <div class="row my-3">
                    <div class="col-sm-6 col-12 p-0 overflow-hidden">
                        <img src="<?php echo"".$_SESSION['img'].""; ?>" alt="profilkép" class="rounded float-md-end d-block mx-auto" id="cserekep" style="max-width: 225px; max-height: 318px;">
                       <input class="float-md-end d-block mx-auto" type="text" name="link" id="" placeholder="Kép linkje..." <?php if($_SESSION['rank'] == "tag") { ?> style="visibility: hidden;" <?php } ?>>
                    </div>
                    <div class="col-sm-6 col-12 my-auto text-sm-start text-center">
                        <p>Felhasználónév:<br><input type="text" name="f_nev" id="" value="<?= $_SESSION['name']; ?>"></p>
                        <p> MAL listád neve:<br><strong><?= $s[1]; ?></strong></p>
                        <p>Rangod:<br><strong><?= $_SESSION['rank']; ?></strong>   <a href="#" data-bs-toggle="modal" data-bs-target="#Fejleszt">Fejlesztés</a>
                        <p>A listád <strong><?= $lista_hossza ?></strong> db animét tartalmaz.</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <input type="submit" class="func_btn" value="Változtatás" name="valtoztat_btn">
                        <input type="reset" onclick="ProfilModosit(0)" value="Mégsem" class="func_btn">
                    </div>
                </div>
                </form>
            </div>

            <form action="profil.php" method="post" class="text-center">
                <input type="submit" value="Fiók törlése" name="delete_btn" class="func_btn">
            </form>

            <!-- Barátok -->
            <div class="text-center my-2">
                <button class="func_btn" onclick="location.href=`baratkozo.php`;">Új barát hozzáadása</button>
            </div>
            <div class="container">
                <div class="row border" style="height: 50vh !important; overflow-y: scroll; max-height: 216px;">
                    <?php
                        baratrajzolo($_SESSION['id']);
                    ?>
                </div>
            </div>

            <!-- Mérföldkövek -->
            <h2 class="text-center">Elért mérföldköveid</h2>
            <p class="text-center"><i class="fa-solid fa-circle-question text-warning"></i> <a href="#" data-bs-toggle="modal" data-bs-target="#MikEzek">Mik is ezek pontosan?</a></p>
            <div class="container mb-3">
                <div class="row">
                    <div class="col-12 text-center">
                        <img src="img/badge/tag.png" class="kituzo" alt="Hiba a kitűző betöltésekor." data-bs-toggle="popover" data-bs-trigger="focus" title="Tag kitűző" data-bs-content="Minden regisztrált felhasználó megkapja." tabindex="0">
                        <?php echo Kituzok($_SESSION['malname']); ?> 
                    </div>
                </div>
            </div>

            <!-- Fejlesztés modal -->
            <div class="modal fade in text-center" id="Fejleszt" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">X</button>
                            <hr class="mb-4">
                            <div class="container-fluid text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <p>Írj nekünk üzenetet.</p>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <form action="profil.php" method="post">
                                            <textarea name="Üzenet..." maxlength="1000" class="w-100 p-2" id="" cols="30" rows="10"></textarea>
                                            <input type="submit" value="Küldés" class="func_btn">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mérföldkövek infó modal -->
            <div class="modal fade in text-center" id="MikEzek" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">X</button>
                            <hr class="mb-4">
                            <div class="container-fluid text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <p>A színek a listádtól függően változnak.</p>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <img src="img/badge/bronze_Action.png" title="Action (10-49)" class="kituzo" alt="Hiba a kitűző betöltésekor.">
                                        <p>Bronz<br>(10 - 49)</p>
                                    </div>
                                    <div class="col-4">
                                        <img src="img/badge/silver_Action.png" title="Action (50-99)" class="kituzo" alt="Hiba a kitűző betöltésekor.">
                                        <p>Ezüst<br>(50 - 99)</p>
                                    </div>
                                    <div class="col-4">
                                        <img src="img/badge/gold_Action.png" title="Action (100+)" class="kituzo" alt="Hiba a kitűző betöltésekor.">
                                        <p>Arany<br>(100+)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <footer class="hatternav text-center align-middle sticky-bottom">
            © SandWitch - 2023
        </footer>
    </body>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</html>
<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
    })
    function remove_friend(id) {
        $.ajax({
            url:"delete_friend.php",
            data:{id:id},
            type:"post"
        })
        setTimeout(function () {
        location.reload()
        }, 100);
    };
</script>