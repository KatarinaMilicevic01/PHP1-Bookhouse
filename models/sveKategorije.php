<?php
    include "../config/connection.php";
    global $conn;

    $upit = "SELECT * FROM kategorija";
    try{
        $rezultat = $conn -> query($upit) -> fetchAll();
        http_response_code(200);
    }
    catch(PDOException $ex){
        http_response_code(500);
        $rezultat = "Greska na serveru";
    }
    echo json_encode($rezultat);
?>