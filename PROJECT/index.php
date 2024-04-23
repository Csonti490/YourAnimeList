<?php
    require "functions.php";
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
    <head>
        <?php include_once("metak.php"); ?>
        <?php include_once("linkek_css.php"); ?>
        <title>YourAnimeList - Főoldal</title>
    </head>
    <body>

        <header>
            <?php include_once("nav.php"); ?>
        </header>

        <main>

            <button type="button" class="btn btn-floating btn-lg border border-white" id="fel_gomb">
            <i class="fas fa-arrow-up"></i>
            </button>

            <div class="container h-50 text-light my-5" id="httr">
                <div class="p-5 text-center"><hr><h1 class="w-100 py-3">Főoldal</h1><hr></div>
            </div>

            <?php if(isset($_GET["welcome"])){ ?>
                <h2 class="text-center mt-3 sz">Üdv. <strong><?= $_SESSION['name']; ?></strong>, sikeresen bejelentkeztél!</h2>
            <?php } ?>

            <!-- Anime ajánló -->
            <h1 class="text-center">Random anime ajánló</h1>
            <?php
                $lekerdezes = "SELECT * FROM folista INNER JOIN statusorder ON folista.state = statusorder.so_state ORDER BY RAND() LIMIT 15";
                $osszes = $conn->query($lekerdezes);
                $animeList = [];

                while ($anime = $osszes->fetch_assoc()) {
                    $animeList[] = $anime;
                }
            ?>
            <!-- Kicsi képváltó -->
            <div class="container d-block d-md-none">
                <div class="row">
                    <div class="col-12">
                        <div class="overflow-hidden mx-auto border border-3 border-secondary" style="max-width: 250px;">
                            <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                                <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($animeList); $i++): ?>
                                    <div class="carousel-item <?= ($i === 0) ? 'active' : '' ?>">
                                        <div class="container p-0">
                                            <div class="mx-auto">
                                                <div class="anime_doboz">
                                                    <img onerror="KepHiba(this)" src="<?= $animeList[$i]['picture']; ?>" class="mx-auto d-block w-100 anime_kep" alt="anime kép" data-bs-toggle="modal" data-bs-target="#adat<?=$i;?>" title="Katt több infóért!">
                                                    <div class="grid-container">
                                                        <div class="anime_szoveg grid-item">
                                                            <p class="m-0"><?= $animeList[$i]['title_jpn']; ?></p>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <span class="text-info"><?= $animeList[$i]['type']; ?></span>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    <span class="text-end"><?= $animeList[$i]['score']; ?> <i class="<?php echo CsillagFajta($animeList[$i]); ?> text-warning"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row m-0 p-0 ajanlo_doboz">
                                                    <div class="col-6 m-0 p-0">
                                                        <button class="w-100 kepvalto_gomb" data-bs-target="#imageCarousel" data-bs-slide="prev" title="Előző">
                                                            <i class="fa-solid fa-chevron-left"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-6 m-0 p-0">
                                                        <button class="w-100 kepvalto_gomb" data-bs-target="#imageCarousel" data-bs-slide="next" title="Következő">
                                                            <i class="fa-solid fa-chevron-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nagy képváltó -->
            <div class="container d-none d-md-block">
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="overflow-hidden">
                            <div id="imageCarousel2" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                                <div class="carousel-inner mx-auto border border-3 border-secondary" style="max-width: 740px;">
                                <?php for ($i = 0; $i < count($animeList); $i++): ?>
                                    <div class="carousel-item <?= ($i === 0) ? 'active' : '' ?>">
                                        <div class="container m-0 p-0">
                                            <div class="row m-0 p-0 ajanlo_doboz">
                                                <div class="col-4 m-0 p-0 ajanlo_kep">
                                                    <img onerror="KepHiba(this)" src="<?=$animeList[$i]['picture']?>" class="anime_kep img-responsive w-100 image-fluid">
                                                </div>
                                                <div class="col-8 ajanlo_szoveg my-auto">
                                                    <p>Japán cím:<br><?=$animeList[$i]['title_jpn']?></p>
                                                    <p>Angol cím:<br><?=$animeList[$i]['title_eng']?></p>
                                                    <p>Típus: <span class="text-primary"><?=$animeList[0]['type']?></span></p>
                                                    <p>Eddigi értékelések átlaga: <?=$animeList[$i]['score']?> <i class="<?php echo CsillagFajta($animeList[$i]); ?> text-warning"></i></p>
                                                    <p>Műfaj: <?=$animeList[$i]['genres']?></p>
                                                    
                                                </div>
                                                <div class="row mt-auto bottom-0 nagyvaltoszovege p-0 m-0">
                                                    <div class="col-6 m-0 p-0">
                                                        <button class="w-100 kepvalto_gomb" data-bs-target="#imageCarousel2" data-bs-slide="prev" title="Előző">
                                                            <i class="fa-solid fa-chevron-left"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-6 m-0 p-0">
                                                        <button class="w-100 kepvalto_gomb" data-bs-target="#imageCarousel2" data-bs-slide="next" title="Következő">
                                                            <i class="fa-solid fa-chevron-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Képinfó, ha kicsi -->
            <?php for ($i = 0; $i < count($animeList); $i++): ?>
            <div class="modal fade text-center" id="adat<?=$i;?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">X</button>
                            <hr class="mb-4">
                            <img onerror="KepHiba(this)" src="<?=$animeList[$i]['picture'];?>" alt="kép helye" class="d-block mx-auto anime_kep">
                            <p>Japán cím: <?=$animeList[$i]['title_jpn'];?></p>
                            <p>Angol cím: <?=$animeList[$i]['title_eng'];?></p>
                            <p>Értékelések átlaga: <?=$animeList[$i]['score'];?></p>
                            <p>Műfaj: <?=$animeList[$i]['genres'];?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
            
            <div class="container fooldalinfo my-5 mx-auto rounded p-3">
                <div class="row">
                    <div class="col-12">
                    <div class="container m-0 p-0" style="text-align: justify;">
                        <h1 class="text-center">Az oldal története</h1>
                        <p class="text-center">Ez az oldal azért jött létre, hogy egy helyen tudjanak értesülni a magyarországon lévő Japán animációkat kedvelők.</p>
                        <h2 class="text-center">Az oldal a következőket tartalmazza</h2>
                        <h4>Interaktív Diagramok</h4>
                        <p>Fedezd fel animés ízlésedet új szemmel az interaktív diagramok segítségével! Áttekintheted, hogy melyik műfajban érzed magad otthon, és melyiket szeretnéd még felfedezni. Legyen szó fantasyról, romantikáról vagy akció-ról, ezek a diagramok segítenek jobban megérteni a személyes animés preferenciáidat.</p>
                        <h4>A Saját Listád</h4>
                        Böngéssz saját animéid között és találd meg azokat, amelyeket még nem fejeztél be, vagy felfüggesztettél! Kereshetsz japán vagy angol név szerint, valamint rendezheted cím vagy értékelés szerint. Így könnyedén rátalálhatsz az új gyöngyszemeket és folytathatod azokat a listádon.</p>
                        <h4>Kitűzők</h4>
                        <p>Gyűjtsd a kitűzőket az animéid nézésével és szerezd meg a megérdemelt elismerést az elért mérföldköveidért! Legyen az a 100. fantasy anime, vagy a 50. horror anime, ezek a kitűzők segítenek megmutatni másoknak, hogy mennyire elkötelezett anime rajongó vagy.</p>
                        <h4>Hírfolyam Magyar Fansubokkal</h4>
                        <p>Légy naprakész a legfrissebb hírekkel és kiadványokkal a magyar fansubok világából. Kövesd nyomon a hírfolyamunkat, hogy mindig az elsők között értesülj az újabb megjelenésekről, fordításokról és eseményekről, és ne maradj le egyetlen fontos frissítésről sem a kedvenc animeiddel kapcsolatban.</p>
                        <h4>Chat Barátokkal</h4>
                        <p>Ne csak egyedül élvezd az animék világát, hanem oszd meg az élményeidet és beszélgess barátaiddal a beépített chat funkció segítségével. Osszátok meg egymással a legújabb felfedezéseiteket, ajánljatok egymásnak újabb sorozatokat, és hozzatok létre közös emlékeket az anime világából.</p>
                    </div>
                </div>
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
<script>
    /* ---------- Oldalcím és háttér ---------- */
    window.onload = (event) => {
    Keptolt();
    };
    var pictures = ['1.png','2.png','3.jpg','4.jpg','5.jpg','6.jpg'];
    var kephely = document.getElementById("httr");
    function Keptolt(){
    var rand = Math.floor(Math.random() * pictures.length);
    kephely.style.backgroundImage = "url(img/bgc/kep"+pictures[rand]+")";
    }
</script>