<?php
    //produccion
   /* 
    $server='localhost';
    $db = 'u293118005_deliloco';
    $user = 'u293118005_userdeliloco';
    $pass = 'Deliloco2020';
    */
    
    //prueba local
    $server='loct';
    $db = 'appecomerce';
    $user = 'root';
    $pass = '';
    


    $link = 'mysql:host='.$server.';dbname='.$db;

    try{
        $pdo = new PDO($link,$user,$pass);

      //  echo 'conectado.';
    }catch(PDOExeption $e){
        print "¡Error!: ".$e->getMessage()."<br>";
        die(); 
    }

?>