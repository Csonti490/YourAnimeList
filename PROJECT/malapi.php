<?php
    require "config.php";
    session_start();
    echo '<script>console.log('.$_SESSION['sql'].')</script>';
    $conn->query($_SESSION['sql']);
 if($_GET['code'] != ""){
    $_SESSION['code']=$_GET['code'];//
}
    if(isset($_SESSION['code'])){
        //echo'<script>console.log("Érvényes kód.")</script>';
        $url = 'https://myanimelist.net/v1/oauth2/token';
        $data = ['client_id' => 'e14d6bb6c566e4a35a779a6cee788c7f',
        'client_secret' => '4aac18a7220524d35f470cadcd15dacf101b0e97c3ffd5277cabea3bfa77365c',
        'code' => $_SESSION['code'],
        'code_verifier' => $_SESSION['cve'],
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'https://team02.project.scholaeu.hu/malapi.php'];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            /* Handle error */
            echo'<script>console.log("HIBA! Nincsen érvényes kód.")</script>';
        }
        $_SESSION['megvan'] = $result;
    }
    if(isset($_SESSION['megvan'])){
        echo'<script>console.log("2")</script>';

        $url = 'https://api.myanimelist.net/v0.20/anime/17074/my_list_status';
        $darab = explode(",", $_SESSION['megvan'])[2];
        $darab2 = explode(":", $darab)[1];
        $darab3 = $both_removed = substr($darab2, 1, -1);
        var_dump($_SESSION['megvan']);
        $access_token = $darab3;
        $user_id=$conn->query("SELECT * FROM users WHERE username='$_SESSION[u]'")->fetch_assoc();
        $conn->query("INSERT INTO Acsses_tokens VALUES(ID,'$user_id[id]','$access_token','".date("Y-n-d")."')");

        $ch = curl_init();

        $watching_status=array('watching','completed','on_hold','dropped','plan_to_watch');
        //$conn->query("TRUNCATE $_SESSION[m]");
        $mal=explode("_",$_SESSION['m']);
        foreach ($watching_status as $key) {
            $url_s='https://api.myanimelist.net/v2/users/'.$mal[1].'/animelist?fields=list_status,title,alternative_titles,main_picture,status,genres,themes,num_episodes,score,media_type&status='.$key.'&sort=anime_title&limit=300&nsfw=true';
            curl_setopt($ch, CURLOPT_URL,$url_s );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $headers = array();
            $headers[] = 'Authorization: Bearer ' . $access_token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
        
            $response = $result;
            //echo"<script>console.log('".$response." Hibás adatok!')</script>";
            $data = json_decode($response, true);
            $ch = curl_init();
            $l = $_SESSION['m'];
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
        header("location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("metak.php"); ?>
    <?php include_once("linkek_css.php"); ?>
    <title>YourAnimeList - Regisztráció</title>
</head>
<body>
    <div class="mt-5">
        <h1 class="text-center">Regisztráció folyamatban...</h1>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img src="img/toothless-dancing.gif" class="d-block mx-auto img-fluid" alt="Loading..." title="Loading...">
                </div>
            </div>
        </div>
    </div>
    
</body>
    <script src="main.js"></script>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>
</html>