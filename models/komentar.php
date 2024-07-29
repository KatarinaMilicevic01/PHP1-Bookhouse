<?php
    session_start();
    include "../config/connection.php";
    global $conn;
    
    $kom=$_GET['kom'];
    $id=$_GET['id'];

    if(isset($_SESSION['korisnik'])){
        $idK=$_SESSION['korisnik']->id_korisnik;
    }

    try{
        $upit = "INSERT INTO komentar(komentar,id_korisnik,id_knjiga) VALUES (:kom, :idK, :id)";
        $priprema = $conn -> prepare($upit);
        $priprema -> bindParam("kom", $kom);
        $priprema -> bindParam("idK", $idK);
        $priprema -> bindParam("id", $id);
        $priprema -> execute();
        
        //var_dump($priprema);

        if($priprema){
            http_response_code(201);
            echo json_encode(["poruka" => "uspeh"]);
        }
        else{
            http_response_code(404);
            echo json_encode(["poruka" => "greska"]);
        }
    }
    catch(PDOException $ex){
        http_response_code(500);
    }
?>