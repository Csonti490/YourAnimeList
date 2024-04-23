<?php
    require "config.php";
    require "functions.php";
    if(isset($_POST['login_btn'])){
        
        Login($_POST['usern'], $_POST['pass']);
    }
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
    <head>
        <?php include_once("metak.php"); ?>
        <?php include_once("linkek_css.php"); ?>
        <title>YourAnimeList - Bejelentkezés</title>
    </head>
    <body>
        <header>
            <?php include_once("nav.php"); ?>
        </header>

        <main>

            <div class="mt-1 align-center">
                <img src="img/neo-bej.png" alt="" id="kabala" class="img-fluid mx-auto d-block">
            </div>
            <div class="container mb-3 text-center regbej">
                <fieldset>
                    <form action="login.php"method="post" autocomplete="on">
                        <div class="row my-3">
                            <div class="col-12">
                                <label>Felhasználónév:</label><br>
                                <input type="text" placeholder="Felhasználónév" name="usern" required="required">
                            </div>

                            <div class="col-12 my-2">
                                <label for="jelszo">Jelszó:</label><br>
                                <input type="password" placeholder="Jelszó" id="password_textbox" name="pass" required="required">
                            </div>

                            <div class="col-12">
                                <input type="checkbox" id="pw_checkbox" onclick="Mutasd()">
                                <label for="jelszo">Jelszó mutatása</label>
                            </div>

                            <div class="col-12 mt-3">
                                <input type="submit" value="Bejelentkezés" name="login_btn" class="w-50">
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>

            <div class="container text-center regbej_link mb-5">
                <a href="regist.php">Regisztráció</a>
                |
                <a href="ujjelszo.php">Elfelejtett jelszó?</a>
            </div>

        </main>
        
        <footer class="hatternav text-center align-middle sticky-bottom">
            © SandWitch - 2023
        </footer>
    </body>
    
    <script src="main.js"></script>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>

</html>

<div class="modal fade" id="problemLogin" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 id="felugro_szoveg" class="modal-title w-100">Biztos, hogy kilépsz?</h4>
      </div>
      <div class="modal-body text-center">
        Semmi
      </div>
      <div class="modal-footer">
        <div class="container-fluid text-center">
          <div class="row">
            <div class="col-12">
                asd
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>