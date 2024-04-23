<?php
	
    require "config.php";
    require "functions.php";
    //require "malapi.php";
    function generateCodeVerifier() {
        $length = 128; // A kívánt hosszúság
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-._~'; // Lehetséges karakterek
        $charsLength = strlen($chars);
        $codeVerifier = '';
    
        for ($i = 0; $i < $length; $i++) {
            $codeVerifier .= $chars[rand(0, $charsLength - 1)];
        }
    
        return $codeVerifier;
    }
    // Új kódverifier generálása
    //echo strlen($codeVerifier) . "\n"; // Ellenőrizhetjük a hosszát
    //echo $codeVerifier; // Kiírjuk a generált kódverifiert
    
    $codeVerifier = generateCodeVerifier();
    $_SESSION['cve'] = $codeVerifier;
    $code_challenge = $codeVerifier;
    if(isset($_POST['regist_btn'])){
        Regist($_POST['mail'],$_POST['usern'],$_POST['maln'],$_POST['pass'],$_POST['pass2'],$code_challenge);
    }

?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
    <head>
        <?php include_once("metak.php"); ?>
        <?php include_once("linkek_css.php"); ?>
        <title>YourAnimeList - Regisztráció</title>
    </head>
    <body>
        <header>
            <?php include_once("nav.php"); ?>
        </header>

        <main>

            <div class="mt-1 align-center">
                <img src="img/neo-reg.png" alt="" id="kabala" class="img-fluid mx-auto d-block">
            </div>
            <div class="container mb-3 text-center regbej">
                <fieldset>
                    <form method="post" action="regist.php" autocomplete="on">
                        <div class="row my-3">
                            <div class="col-12 mb-2">
                                <label for="fnev">E-mail cím:</label><br>
                                <input type="mail" placeholder="E-mail cím" name="mail" required="required" value="<?=$_SESSION['mail']?>">
                            </div>

                            <div class="col-12 mb-2">
                                <label for="fnev">Felhasználónév:</label><br>
                                <input type="text" placeholder="Felhasználónév" name="usern" required="required" value="<?=$_SESSION['u']?>">
                            </div>

                            <div class="col-12 mb-2">
                                <label for="malnev">MAL név:</label><br>
                                <input type="text" placeholder="MAL név" name="maln" required="required" value="<?=$_SESSION['m2']?>">
                            </div>

                            <div class="col-12 mb-2">
                                <label for="jelszo">Jelszó:</label><br>
                                <input type="password" placeholder="Jelszó" id="password_textbox" name="pass" pattern="[A-Za-z0-9]{5,}" title="[A-Z], [a-z], [0-9]. Minimum öt karakter." required="required" value="<?=$_SESSION['p']?>">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="jelszo">Jelszó mégegyszer:</label><br>
                                <input type="password" placeholder="Jelszó mégegyszer" id="password2_textbox" name="pass2" pattern="[A-Za-z0-9]{5,}" title="[A-Z], [a-z], [0-9]. Minimum öt karakter." required="required" value="<?=$_SESSION['p2']?>">
                            </div>
            
                            <div class="col-12 mb-1">
                                <input type="checkbox" id="pw_checkbox" onclick="Mutasd()">
                                <label for="jelszo">Jelszó mutatása</label>
                            </div>

                            <div class="mb-3">
                                <input type="checkbox" id="ff" required="required">
                                <label for="ff"><a href="#" data-bs-toggle="modal" data-bs-target="#fel_fel">Felhasználási feltételek</a></label>
                            </div>

                            <div>
                                <input type="submit" value="Regisztráció" name="regist_btn" class="w-50">
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>

            <!--Felhasználási feltételek-->
            <div class="modal fade" id="fel_fel" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header text-center">
                    <h4 class="modal-title w-100">Felhasználási feltételek</h4>
                    <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">X</button>
                  </div>
                  <div class="modal-body">
                    <p class="text-center">Kérjük, figyelmesen olvassa el az alábbi felhasználási feltételeket, mielőtt használná az oldalunkat vagy szolgáltatásainkat.</p>
                    <hr class="mb-0">
                    <div class="p-3" style="height: 50vh !important; overflow-y: scroll;">
                        <p><span>1</span> Elfogadás: Az oldalunk vagy szolgáltatásaink használatával Ön kijelenti, hogy elolvasta, megértette és elfogadja a jelen Felhasználási Feltételeket. Amennyiben nem ért egyet ezekkel a feltételekkel, kérjük, ne használja szolgáltatásainkat.</p>
                        <p><span>2</span> Szolgáltatások: Az oldalunkon keresztül különböző szolgáltatásokat kínálunk, amelyekhez különböző feltételek és korlátozások is kapcsolódnak. Az egyes szolgáltatások használata előtt kérjük, olvassa el a hozzájuk tartozó specifikus feltételeket.</p>
                        <p><span>3</span> Felhasználói fiókok: Bizonyos szolgáltatásokhoz regisztráció szükséges. A regisztráció során kötelező adatokat meg kell adnia, és felelősséggel tartozik az általa megadott információk pontosságáért. Felhasználói fiókjával kapcsolatos minden tevékenységért Ön felelős.</p>
                        <p><span>4</span> Felhasználói viselkedés: Az oldalunkon tiszteletben kell tartani más felhasználók jogait és személyes információit. Tilos bármilyen jogszabálysértő, törvénybe ütköző vagy etikailag aggályos tevékenységet folytatni.</p>
                        <p><span>5</span> Tartalmi jogok: Az oldalunkon közzétett tartalmakhoz, beleértve a szövegeket, képeket és videókat, szellemi tulajdonjogok kapcsolódnak. A tartalmak felhasználása vagy terjesztése a jogtulajdonos előzetes írásbeli engedélyével lehetséges.</p>
                        <p><span>6</span> Adatvédelem: Az adatvédelmi irányelveink részletesen leírják, hogy hogyan kezeljük az Ön személyes adatait. Kérjük, olvassa el az irányelveket, hogy tájékozott legyen az adatkezelési gyakorlatunkról.</p>
                        <p><span>7</span> Felelősség korlátozása: Az oldalunk és szolgáltatásaink használata kizárólag saját felelősségére történik. Nem vállalunk felelősséget semmilyen közvetlen vagy közvetett kárért, ami az oldalunk használatából vagy az azt követő eseményekből származik.</p>
                        <p><span>8</span> Módosítások: Fenntartjuk a jogot, hogy bármikor módosítsuk vagy frissítsük ezeket a Felhasználási Feltételeket. Az új feltételek hatályba lépése előtt értesítést küldünk Önnek az esetleges változtatásokról.</p>
                        <p><span>9</span> Joghatóság és vitarendezés: Ezekre a Felhasználási Feltételekre a helyi jogszabályok az irányadók. Bármely esetleges vita esetén mindkét fél vállalja, hogy elsődlegesen a vitás kérdéseket békés úton próbálják megoldani.</p>
                    </div>
                    <hr class="mt-0">
                    <p class="text-center">Az oldalunk vagy szolgáltatásaink használatával Ön elfogadja és beleegyezik ezekbe a Felhasználási Feltételekbe.</p>
                  </div>
                  <div class="modal-footer">
                    <h4>&nbsp;</h4>
                  </div>
                </div>
              </div>
            </div>

            <div class="container text-center regbej_link mb-5">
                <a href="login.php">Bejelentkezés</a>
                |
                <a href="ujjelszo.php">Elfelejtett jelszó?</a>
            </div>

        </main>

        <footer class="hatternav text-center align-middle sticky-bottom">
            © SandWitch - 2023-2024
        </footer>

    </body>
    <script src="main.js"></script>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>
</html>