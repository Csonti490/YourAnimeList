<?php
    require "functions.php";
    if(isset($_POST['changepls_btn'])){
        $k = KodGen();
        $link = "http://team02.project.scholaeu.hu/ujjelszo.php?kod=".$k;
        $message = "Új jelszó igénylése\r\nLink:\r\n".$link;
        $message = wordwrap($message, 70, "\r\n");

        //mail($_POST['m'], "YourAnimeList - Új jelszó", $message);
        $tag = $conn->query("SELECT * FROM users WHERE mail LIKE '$_POST[m]'");
        $conn->query("INSERT INTO `newpass`(`id`, `code`, `userid`, `verify`) VALUES (id,'$k',$tag[id],0)");
        echo "<script>alert('Küldtünk egy emailt!')</script>";
    }
    if(isset($_POST['newpass_btn'])){
        $k = $_GET['kod'];
        if($_POST['p1'] == $_POST['p2']){
            $secret_pass = password_hash($_POST['p1'], PASSWORD_DEFAULT);
            $tag = $conn->query("SELECT * FROM newpass WHERE code LIKE '$k'")->fetch_assoc();
            $conn->query("UPDATE `users` SET `password`='$secret_pass' WHERE id = $tag[id]");
            $conn->query("UPDATE `newpass` SET `verify`=1 WHERE code LIKE '$k'");
            echo "<script>alert('Sikeres jelszócsere!')</script>";
            header("Location: login.php");
        }else{
            echo "<script>alert('A két jelszó nem egyezik!')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
    <head>
        <?php include_once("metak.php"); ?>
        <?php include_once("linkek_css.php"); ?>
        <title>YourAnimeList</title>
    </head>
    <body>

        <header>
            <?php include_once("nav.php"); ?>
        </header>

        <main>

            <!-- Új jelszó kérése -->
            <?php if($_GET['kod'] == "" || mysqli_num_rows($conn->query("SELECT * FROM newpass WHERE code = '$_GET[kod]'")) == 0) { ?>
            <div class="mt-5 align-center">
                <img src="img/moe_1.png" alt="" id="kabala" class="img-fluid mx-auto d-block">
            </div>
            <div class="container text-center mb-3 ujp">
                <div class="row my-3">
                    <form action="ujjelszo.php" method="post">
                        <div class="col-12 mb-2">
                            <label class="mb-2" for="m_ujjelszo">Email megadása:</label><br>
                            <input class="mb-2" type="text" name="m" placeholder="Mail" id="m_ujjelszo"><br>
                        </div>
                        <div class="col-12 mb-2">
                            <input class="mb-2" type="submit" name="changepls_btn" value="Új jelszó igénylése">
                        </div>
                    </form>
                </div>
            </div>
            <?php } ?>

            <!-- Új jelszó beállítása -->
            <?php if($_GET['kod'] != "") {  if(mysqli_num_rows($conn->query("SELECT * FROM newpass WHERE code = '$_GET[kod]'")) == 1) { ?>
            <div class="mt-5 align-center">
                <img src="img/moe_2.png" alt="" id="kabala" class="img-fluid mx-auto d-block">
            </div>
            <div class="container text-center mb-3 ujp">
                <diw class="row my-3">
                    <form action="ujjelszo.php?kod=<?=$_GET['kod']?>" method="post">
                        <div class="col-12 mb-2">
                            <label for="p1_ujjelszo">Új jelszó:</label><br>
                            <input type="text" name="p1" id="p1_ujjelszo" placeholder="Új jelszó">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="p2_ujjelszo">Új jelszó mégegyszer:</label><br>
                            <input type="text" name="p2" id="p2_ujjelszo" placeholder="Új jelszó mégegyszer">
                        </div>
                        <div class="col-12 mb-2">
                            <input type="submit" name="newpass_btn" value="Új jelszó beállítása">
                        </div>
                    </form>
                </diw>
            </div>
            <?php } } ?>

            <div class="container text-center regbej_link mb-5">
                <a href="regist.php">Regisztráció</a>
                |
                <a href="login.php">Bejelentkezés</a>
            </div>

        </main>

        <footer class="hatternav text-center">
            © SandWitch - 2023
        </footer>
        
    </body>

    <script src="main.js"></script>
    <script src="felgomb.js"></script>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>
</html>