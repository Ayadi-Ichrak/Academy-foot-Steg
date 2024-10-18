<?php
require_once "connection.php";
require_once "securite.php";
?>
<html>
    <head>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<link rel="stylesheet" href="styleGestionnaire.css">
<title>SCAN QR CODE</title>

    </head>
    <body>
        <div class="navbar">
            <div class="logo">
                <img src="./img/logo-removebg.png">
                <span class="title">Tiger foot Academy</span>
            </div>
            <a href="logout.php"><ion-icon name="power-outline"></ion-icon></a>
        </div>
       
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <video id="preview" width="100%"></video>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="process_scan.php">
                    <label>SCAN QR CODE</label>
                    <input type="text" name="code_joueur" id="text" readonyy=""  class="form-control">
                    <input type="submit" value="Verifier">
                    </form>
                </div>
            </div>
        </div>

        <script>
           let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[0]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
               document.getElementById('text').value=c;
           });
           
        </script>
         <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
         <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    </body>
</html>