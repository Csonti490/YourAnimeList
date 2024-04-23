<?php
    require "functions.php";
    $imhere = "uzenet";
    if (isset($_POST['send_btn'])) {
        $anyad=$_GET['conv_id'];
        fc_send_message($_POST['message'],$anyad);
    }
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
    <head>
        <?php include_once("metak.php"); ?>
        <?php include_once("linkek_css.php"); ?>
        <script src="https://code.jquery.com/jquery-latest.js"></script>
        <title>YourAnimeList - Üzeneteid</title>
    </head>
    <body>
        <header>
            <?php include_once("nav.php"); ?>
        </header>

        <main>

            <div class="container mt-3">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div id=0 class="converstations"></div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div id=1 class="chat"></div>
                        <div class="send" id=2>A beszélgetés megnyitásához kattints EGYSZER valakire!</div>
                    </div>
                </div>
            </div>

        </main>

        <footer class="hatternav text-center">
            © SandWitch - 2023
        </footer>

    </body>

    <script src="main.js"></script>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <script>
        var xhr=new XMLHttpRequest();
        var id=null;
        xhr==$('#1').load('chat.php?conv_id='+id);
        setInterval(r,1000);
        function r(){
            $('#0').load('conversations.php');
        };
        function chat_open(idf){
            id=idf;
            refresher();
            setTimeout(g,1500)
            function g(){
            $('.chat').scrollTop($('.chat')[0].scrollHeight*$('.chat')[0].scrollHeight);
            $('#2').load('send.php?conv_id='+id);
            $('.chat').scrollTop($('.chat')[0].scrollHeight*$('.chat')[0].scrollHeight);
            }
        };
        function refresher(){
            setInterval(h,1000);
            function h() {
                if (xhr.DONE==4) {
                    xhr.abort();
                }
                xhr=$('#1').load('chat.php?conv_id='+id);
            }
        };
        function send(id) {
          var message= document.getElementById("4").value;
            $.ajax({
                url:"send_msg.php",
                data:{message:message,id:id},
                type:"post"
            })
        };
    </script>
</html>