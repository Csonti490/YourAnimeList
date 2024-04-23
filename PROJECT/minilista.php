<?php
    session_start();
    require "config.php";
    if ($_GET['keresett']!="") {
      $keresett=rawurldecode($_GET['keresett']);
      //echo '<script>console.log("'.$_POST['keresett'].'")</script>';
    }
    else {
      $keresett="";
    }
    $lekerdezes = "SELECT * FROM $_SESSION[malname] WHERE title_jpn LIKE '%$keresett%' OR title_eng LIKE '%$keresett%'";
    $osszes=$conn->query($lekerdezes);
    while($anime=$osszes->fetch_assoc()){
?>
  <div class="w-100 border animesor">
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
          <input type="submit" value="&nbsp;" onclick="location.href='modositas.php?modositando=<?=$anime['id'];?>'" class="px-3">
        </td>
      </tr>
    </table>
  </div>
<?php } ?>
