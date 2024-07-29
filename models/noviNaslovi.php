<?php
    include "../config/connection.php";
    global $conn;
    $upit = "SELECT * FROM knjiga k JOIN autor a ON k.id_autor = a.id_autor ORDER BY datum_izdanja DESC LIMIT 4";
    try{
        $rezultat = $conn -> query($upit) -> fetchAll();
        $code = 200;
    }
    catch(PDOException $ex){
        $rezultat = "Greska na serveru";
        $code = 500;
    }
    http_response_code($code);
    echo json_encode($rezultat);
?>