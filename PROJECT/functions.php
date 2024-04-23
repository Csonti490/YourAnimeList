<?php
session_start();
require "config.php";

/*---------- Regisztráció ----------*/
$_SESSION['mail']=$mail;
$_SESSION['u']="";
$_SESSION['m2']="";
$_SESSION['p']="";
$_SESSION['p2']="";
function Regist($mail,$username, $malname, $password, $password2, $code_challenge){
    require "config.php";
    $_SESSION['mail']=$mail;//felhasználó emailje
    $_SESSION['u']=$username;//felhasználó név
    $_SESSION['m']="YAL_".$malname;//MAL név plusz YAL_ kiterjesztés a könyebb és gyorsabb keresés miatt
    $_SESSION['m2']=$malname;//MAL név, ha esetleg nem sikerült a regisztráció
    $_SESSION['p']=$password;
    $_SESSION['p2']=$password2;//Jelszavak 

    if($password!=$password2){
        echo "<script>alert('A két jelszó nem egyezik!')</script>";//Hiba (nem egyezik a két jelszómező)
    }
    else {

        $lekerdezes = "SELECT * FROM users WHERE mail='$mail'";
        $talalt_mail = $conn->query($lekerdezes);
        if(mysqli_num_rows($talalt_mail) == 0){//Új email-e

            $lekerdezes = "SELECT * FROM users WHERE malname='$malname'";
            $talalt_malname = $conn->query($lekerdezes);
            if(mysqli_num_rows($talalt_malname) == 0){//Új MAL fiók-e

                $lekerdezes = "SELECT * FROM users WHERE username='$username'";
                $talalt_felhasznalo = $conn->query($lekerdezes);
                if(mysqli_num_rows($talalt_felhasznalo) == 0){//Új felhasználó-e

                    $secret_pass = password_hash($password, PASSWORD_DEFAULT);
                    $_SESSION['sql']="INSERT INTO users VALUES(id, '$mail', '$username', '$secret_pass', '$_SESSION[m]', 'tag','img/YAL_profilepicture.png')";
                    
                    echo '<script> window.location.href ="https://myanimelist.net/v1/oauth2/authorize?response_type=code&client_id=e14d6bb6c566e4a35a779a6cee788c7f&redirect_uri=https://team02.project.scholaeu.hu/malapi.php&code_challenge='.$code_challenge.'&code_challenge_method=plain";</script>';//API hitelesítés

                }else{
                    echo "<script>alert('Sajnos regisztráltak ezzel a felhasználónévvel!')</script>";
                }

            }else{
                echo "<script>alert('Már regisztráltak ezzel a MAL fiókkal!')</script>";
            }

        }
        else{
            echo "<script>alert('Már regisztráltak ezzel az email-címmel!')</script>";
        }

    }
}

/*---------- Bejelentkezés ----------*/
function Login($username, $password){
    require "config.php";
    $lekerdezes = "SELECT * FROM users WHERE username='$username'";
    $talalt_felhasznalo = $conn->query($lekerdezes);

    if(mysqli_num_rows($talalt_felhasznalo) == 1){
        $felhasznalo = $talalt_felhasznalo->fetch_assoc();
        
        if(password_verify($password,$felhasznalo['password'])){
            $_SESSION['id'] = $felhasznalo['id']; //Felhasználó ID
            $_SESSION['name'] = $felhasznalo['username']; //Név
            $_SESSION['malname'] = $felhasznalo['malname']; //Felhasználónév
            $_SESSION['email'] = $felhasznalo['mail']; //Email
            $_SESSION['rank'] = $felhasznalo['rank']; //Rang
            $_SESSION['img']=$felhasznalo['img'];//Kép
            $_SESSION['modositando'] = "";//Módosítandó anime
            if (date_diff(date_create(date("Y-n-d")),date_create($conn->query("SELECT * FROM Acsses_tokens WHERE Userid=$felhasznalo[id]")->fetch_assoc()['Date']))->format("%R%a")=="+1") {
                
            }
            header("Location: index.php?welcome"); //Főoldalra küld elösször
        }else{
            echo "<script>alert('Helytelen jelszó!')</script>"; //Helytelen jelszó hiba
        }
            
    }
    else{
        echo "<script>alert('Nincs ilyen felhasználó regisztrálva!')</script>"; //Nincs ilyen felhasználó hiba
    }
}

/*---------- Kijelentkezés gombja ----------*/
if(isset($_POST['logout_btn'])){
    session_unset();
    session_destroy();
}

/*---------- Státusz jelölések ----------*/
function Statusz($anime) {
    switch ($anime['state']) {
        case 'Watching':
            return "border border-3 border-success";
            break;
        case 'Completed': 
            return "border border-3 border-primary";
            break;
        case 'On Hold':
            return "border border-3 border-warning";
            break;
        case 'Dropped': 
            return "border border-3 border-danger";
            break;
        case 'Plan to Watch': 
            return "border border-3 border-secondary";
            break;
    }
}
/*---------- Felugró ablak nevek rövödítése, ha kell ----------*/
function Nevek($anime){
    if($anime['title_jpn'] === $anime['title_eng']){
        return "<p>Cím:<br>".$anime['title_jpn']."</p>";
    }else{
        return "<p>Japán cím:<br>".$anime['title_jpn']."</p>
        <p>Angol cím:<br>".$anime['title_eng']."</p>";
    }
    
}
/*---------- Felugró ablak értékelésének szépített kiírása ----------*/
function Ertekeles($anime){
    switch ($anime['score']) {
        case 10:
            return "10 - Mestermű";
            break;
        case 9: 
            return "9 - Nagyszerű";
            break;
        case 8:
            return "8 - Nagyon jó";
            break;
        case 7: 
            return "7 - Jó";
            break;
        case 6: 
            return "6 - Korrekt";
            break;
        case 5: 
            return "5 - Közepes";
            break;
        case 4: 
            return "4 - Rossz";
            break;
        case 3: 
            return "3 - Nagyon rossz";
            break;
        case 2: 
            return "2 - Szörnyű";
            break;
        case 1: 
            return "1 - Nézhetetlen";
            break;
        case 0: 
            return "Még nem értékeltem";
            break;
    }
}

/*---------- A státuszok átírása magyarra ----------*/
function MagyarStatusz($anime){
    switch ($anime['state']) {
        case 'Watching':
            return "Nézés alatt";
            break;
        case 'Completed': 
            return "Befejezve/Megnézve";
            break;
        case 'On Hold':
            return "Megnézés szüneteltetve";
            break;
        case 'Dropped': 
            return "Eldobva/Kukázva";
            break;
        case 'Plan to Watch': 
            return "Mégnézendő";
            break;
    }
}

/*---------- Csillag jelölések ----------*/
function CsillagFajta($anime){
    if($anime['score'] == 0)
        return "fa-regular fa-star";
    else if($anime['score'] <= 5)
        return "fa-solid fa-star-half-stroke";
    else
        return "fa-solid fa-star";
}

/*---------- Elért mérföldkövek ----------*/
function Kituzok($malname){
    require "config.php";

    $fajtak = array("Action","Adventure","Fantasy","Gore","Mecha","School","Romance|Love","Slice of Life","Sports");
    $lekerdezes = "SELECT * FROM $malname";
    
    for($i = 0; $i < count($fajtak); $i++){
        
        $db = 0;
        $animek = $conn->query($lekerdezes." WHERE genres REGEXP '".$fajtak[$i]."' AND state LIKE 'Completed'");
        
        while($animek->fetch_assoc()){
            $db+=1;
        }

        if($db >= 10)
            echo KituzoFokozat($fajtak, $i, $db);

    }
    
}

/*---------- Kitűző rang eldöntése ----------*/
function KituzoFokozat($tomb, $i, $db){
    $fajtak = $tomb;
    $fajlnevek = array("Action","Adventure","Fantasy","Gore","Mecha","School","Romance","SliceOfLife","Sports");
    $fajl_nev = $fajlnevek[$i];
    
    $kituzo_erteke = "bronze"; // 10 -> bronz
    if($db >= 50 && $db < 100)
        $kituzo_erteke = "silver"; // 50 - 99 -> ezüst
    else if($db >= 100)
        $kituzo_erteke = "gold"; // 100+ -> arany
    
    // A kitűző címének szépített kiírása
    $nev = $fajtak[$i];
    if(str_contains($nev,"|")){
        $nev_tomb = explode("|",$nev);
        $nev = "";
        for($i = 0; $i<count($nev_tomb); $i++){
            $nev .= $nev_tomb[$i].", ";
        }
        $nev = rtrim($nev, ", ");
    }
    $pluszinfok = 'data-bs-toggle="popover" data-bs-trigger="focus" title="'.$nev.' kitűző" data-bs-content="Azért kaptad, mert megnéztél '.$db.' db '.$nev.' animét." tabindex="0"'; //Kitűző kattintásra felugró ablak
    return '<img src="img/badge/'.$kituzo_erteke.'_'.$fajl_nev.'.png" class="kituzo" alt="Hiba a kitűző betöltésekor." '.$pluszinfok.'> '; //Kitűzőkép kirakása
}

/*---------- Chat funkciók ----------*/
function fc_conversation($id){//Beszélgetések kirajzolása
    require "config.php";
    $conversations=$conn->query("SELECT * FROM conversations WHERE sender_id = $id OR adressed_id =$id ORDER BY opened_date DESC");//Beszélgetéseklekérdezése felhasználok alapján
    if (mysqli_num_rows($conversations)>0) {
        while ($conversation=$conversations->fetch_assoc()) {
            if ($id==$conversation['sender_id']) {
                $conn_id="adressed_id";
            }
            else{
                $conn_id="sender_id";
            }
            $user=$conn->query("SELECT * FROM users WHERE id=$conversation[$conn_id]")->fetch_assoc();
            if (mysqli_num_rows($conn->query("SELECT * FROM messages WHERE conversation_id=$conversation[id] ORDER BY send_date DESC"))!=0) {
                $messages=$conn->query("SELECT * FROM messages WHERE conversation_id=$conversation[id] ORDER BY send_date DESC")->fetch_assoc();
                if ($messages['seen']) {
                    echo'
                        <div class="convesation d-inline-block d-lg-block" onclick="chat_open('.$conversation['id'].')">
                            <img src="img/YAL_profilepicture.png" class="chat_profil">
                            <span class="chat_name">'.$user['username'].'</span>
                        </div>
                    ';
                }
                elseif (!$messages['seen']) {
                    echo'
                    <div class="convesation d-inline-block d-lg-block" onclick="chat_open('.$conversation['id'].')">
                        <img src="img/YAL_profilepicture.png" class="chat_profil">
                        <span class="chat_name">'.$user['username'].'  <img class="pici" src="img/giphy.gif"> </span>
                    </div>
                ';
                }
            }
            else {
                echo'
                    <div class="convesation d-inline-block d-lg-block" onclick="chat_open('.$conversation['id'].')">
                        <img src="img/YAL_profilepicture.png" class="chat_profil">
                        <span class="chat_name">'.$user['username'].' +<i class="fa-solid fa-user-group"></i> </span>
                    </div>
                ';
            }
        }
    }
    else{
        echo'Nincsenek beszélgetéseid  :(';//Ha nincsen semmilyen beszélegtésed senkivel
    }
};
    
/*---------- Üzenetek betöltése ----------*/
function fc_chat_messages($id){
    require "config.php";
    $messages=$conn->query("SELECT * FROM messages WHERE conversation_id=$id ORDER BY send_date");
    $conn->query("UPDATE conversations SET opened_date='".date("Y-n-d H:i:s")."'");
    if (mysqli_num_rows($messages)>0) {
        while ($message=$messages->fetch_assoc()) {
            $conn->query("UPDATE messages SET seen=1 WHERE id=$message[id]");
            if ($message['user_id']==$_SESSION['id']) {
                echo'<div class="sender message">'.htmlspecialchars_decode($message['message']).'</div><br><br>';
            }
            else {
                echo'<div class="getter message">'.htmlspecialchars_decode($message['message']).'</div>';
            }
        }
    }
    else{
        echo'<img src="img/ramrem_chat.png" class="d-block mx-auto" id="ramrem_chat">'; //Kép amíg nincs beszélgetés választva
    }
};

/*---------- Üzenet elküldése ----------*/
function fc_send_message($message,$id){
    require "config.php";
    $conn->query("INSERT INTO messages VALUES(id,$id,$_SESSION[id],'$message','".date("Y-n-d H:i:s")."',0)"); //Üzenet feltöltése adatbázisba
}

/*-------------- frissités ------------------*/
function frissit(){
    require "config.php";
    $ch = curl_init();
    $access_token=$conn->query("SELECT * FROM Acsses_tokens WHERE Userid=$_SESSION[id]")->fetch_assoc();
    $watching_status=array('watching','completed','on_hold','dropped','plan_to_watch');
    //$conn->query("TRUNCATE $_SESSION[m]");
    $mal=explode("_",$_SESSION['malname']);
    $conn->query("TRUNCATE $_SESSION[malname]");
    foreach ($watching_status as $key) {
        $url_s='https://api.myanimelist.net/v2/users/'.$mal[1].'/animelist?fields=list_status,title,alternative_titles,main_picture,status,genres,themes,num_episodes,score,media_type&status='.$key.'&sort=anime_title&limit=300&nsfw=true';
        curl_setopt($ch, CURLOPT_URL,$url_s );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $access_token['Token'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    
        $response = $result;
        //echo"<script>console.log('".$response."3')</script>";
        $data = json_decode($response, true);
        $ch = curl_init();
        $l = $_SESSION['malname'];
        $sql = "CREATE TABLE IF NOT EXISTS $l (
            id int(11) AUTO_INCREMENT,
            title_jpn mediumtext,
            title_eng mediumtext,
            score int(11),
            type mediumtext,
            state mediumtext,
            episode1 int(11),
            episode2 int(11),
            genres mediumtext,
            picture mediumtext,
            malid int(11),
            PRIMARY KEY(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";
        $conn->query($sql);
        foreach ($data['data'] as $item) {
            $id = $item['node']['id'];
            $title = $item['node']['title'];
            $score = $item['list_status']['score'];
            $picture = $item['node']['main_picture']['medium'];
            if (strlen($item['node']['alternative_titles']['en'])<1) {
                $alternativeTitles=$title;
            }
            else {
                $alternativeTitles = $item['node']['alternative_titles']['en'];
            }
            $status=$item['node']['status'];
            if (empty($item['node']['genres'])) {
                $genres="Music";
            }
            else{
                $genres = implode(", ", array_column($item['node']['genres'], 'name'));
            }
            $numEpisodes = $item['node']['num_episodes'];
            if (str_contains($item['list_status']['status'],"_")) {
                $s=explode("_",$item['list_status']['status']);
                if (count($s)==2) {
                        $watchingStatus =ucfirst($s[0])." ".ucfirst($s[1]);
                }
                else {
                    $watchingStatus = ucfirst($s[0])." ".$s[1]." ".ucfirst($s[2]); 
                }
            }
            else {
                $watchingStatus =ucfirst($item['list_status']['status']);
            }
             
            $numEpisodesWatched = $item['list_status']['num_episodes_watched'];
            if (strlen($item['node']['media_type'])>3) {
                $s=explode("_",$item['node']['media_type']);
                if (count($s)==2) {
                    $media_type = strtoupper($s[0])." ".ucfirst($s[1]);
                }
                else{
                $media_type = ucfirst($item['node']['media_type']);
                }
            }
            else {
                $media_type = strtoupper($item['node']['media_type']);
            }
            if (str_contains($alternativeTitles,"'") && str_contains($alternativeTitles,'"')) {
            $alternativeTitles=addslashes($alternativeTitles); 
            $alternativeTitles=str_replace('\"','',$alternativeTitles);
            }
            if (str_contains($title,'"')||str_contains($title,'"')) {
                $title=addslashes($title);
                $title=str_replace('\"','',$title);
            }
            if (str_contains($alternativeTitles,"'")||str_contains($title,"'")) {
                $sql = 'INSERT INTO '.$l.'
                VALUES (id,"'.$title.'", "'.$alternativeTitles.'", '.$score.', "'.$media_type.'", "'.$watchingStatus.'", '.$numEpisodesWatched.', '.$numEpisodes.', "'.$genres.'", "'.$picture.'",'.$id.')';
            }
            else {
                $sql = "INSERT INTO $l 
                VALUES (id,'$title', '$alternativeTitles', $score, '$media_type', '$watchingStatus', $numEpisodesWatched, $numEpisodes, '$genres', '$picture',".$id.")";
            }
            $conn->query($sql);
            if(mysqli_num_rows($conn->query("SELECT * FROM folista WHERE malid = $id")) == 0){
                $l = "folista";
                if (str_contains($alternativeTitles,"'") && str_contains($alternativeTitles,'"')) {
                    $alternativeTitles=addslashes($alternativeTitles); 
                    $alternativeTitles=str_replace('\"','',$alternativeTitles);
                }
                if (str_contains($title,'"')||str_contains($title,'"')) {
                    $title=addslashes($title);
                    $title=str_replace('\"','',$title);
                }
                if (str_contains($alternativeTitles,"'")||str_contains($title,"'")) {
                    $sql = 'INSERT INTO '.$l.'
                    VALUES (id,"'.$title.'", "'.$alternativeTitles.'", '.$score.', "'.$media_type.'", "'.$watchingStatus.'", '.$numEpisodesWatched.', '.$numEpisodes.', "'.$genres.'", "'.$picture.'",'.$id.')';
                }
                else {
                    $sql = "INSERT INTO $l 
                    VALUES (id,'$title', '$alternativeTitles', $score, '$media_type', '$watchingStatus', $numEpisodesWatched, $numEpisodes, '$genres', '$picture',".$id.")";
                }
                $conn->query($sql);
            }

        }
    }//foreach end
    header("location: lista.php");
}

/*-------------- Profil oldalon a barátok kilistázása ------------------*/
function baratrajzolo($id){
    require "config.php";
    if (mysqli_num_rows($conn->query("SELECT* FROM friends_list WHERE userid=$id"))!=0) {
        $baratok=explode(",",$conn->query("SELECT* FROM friends_list WHERE userid=$id")->fetch_assoc()['friends_id']);
        foreach ($baratok as $l) {
            if (!empty($l)) {
                echo '<div class="col-lg-2 col-md-3 col-sm-4 col-4 m-2">
                <div class="a_doboz border border-3 border-dark">
                    <img src="'.$conn->query("SELECT * FROM users WHERE id=$l")->fetch_assoc()['img'].'" alt="Nem sikerült betölteni a képet" class="mx-auto d-block w-100 a_kep">
                    <div class="a_szoveg">
                        <h5>'.$conn->query("SELECT * FROM users WHERE id=$l")->fetch_assoc()['username'].'</h5>
                        <button class="d-inline-block float-start" onclick="location.href=`uzenet.php`;"><i class="fa-solid fa-square-envelope"></i></button>
                        <button class="d-inline-block float-end" onclick="remove_friend('.$conn->query("SELECT * FROM users WHERE id=$l")->fetch_assoc()["id"].')"><i class="fa-solid fa-square-xmark"></i></button>
                    </div>
                </div>
            </div>';
            }
        }
    }
    
}

function KodGen(){
    $betuk='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $kodi='';
    for ($i=0; $i < strlen($betuk); $i++) { 
        $kodi.=$betuk[rand(0,strlen($betuk))];
        //echo $kodi."<br>";
    }
    if(mysqli_num_rows($conn->query("SELECT * FROM newpass WHERE code = $kodi")) == 0){
        return $kodi;
    }
    else{
        KodGen();
    }
}

?>

