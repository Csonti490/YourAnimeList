<?php
    session_start();
    require "functions.php";
    if ($_GET['keresett']!="") {
      $keresett=rawurldecode($_GET['keresett']);
    }
    else {
      $keresett="";
    }
    $lekerdezes = "SELECT * FROM folista WHERE title_jpn LIKE '%$keresett%' OR title_eng LIKE '%$keresett%' LIMIT 10";
    $osszes=$conn->query($lekerdezes);
    if(mysqli_num_rows($conn->query($lekerdezes)) == 0){
        echo "<h4 class='text-center mt-3'>Nincs ilyen anime az adatbázisisunkban.</h4>";
    }else{
    while($anime=$osszes->fetch_assoc()){
?>
    <div class="w-100 border animesor p-0">
        <table>
            <tr>
                <td>
                    <img src="<?=$anime['picture'];?>" onerror="KepHiba(this)" class="kiskep d-block mx-auto">
                </td>
                <td>
                <div class="cimek">
                    <?=$anime['title_jpn'];?>
                    <br>
                    <?=$anime['title_eng'];?>
                </div>
                </td>
                <td>
                    <input type="button" value="&nbsp;" onclick="Kepmentes(<?php echo $anime['malid']; ?>); KepValaszt(<?=$anime['malid'];?>)">
                </td>
            </tr>
        </table>
    </div>
<?php } } ?>