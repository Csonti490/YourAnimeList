<?php
require "functions.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["kep"])) {
        $data = $_POST["kep"];

        $conn->query("INSERT INTO `news`(`id`, `sender`, `title`, `text`, `picture`, `link`, `postdate`) VALUES (id,'$_SESSION[u]','---','---','$data','---',NOW())");
    echo "<script>alert('Hír közölve!')</script>";
        // Most már $kep változóban tárolódik az űrlapról érkező adat
        //echo "Az űrlapról érkező adat: " . $kep;
    } else {
        //echo "Nincs adat az űrlapról érkező adatban.";
    }
}
?>