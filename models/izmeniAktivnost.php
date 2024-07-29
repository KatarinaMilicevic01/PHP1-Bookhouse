<?php
    include "../config/connection.php";
    global $conn;

    if(!isset($_GET['id'])){
        http_response_code(500);
    }
    else{
        $id = $_GET['id'];
        $aktivnost = $_GET['aktivnost'];
        try{
            $upit = "UPDATE pitanja p JOIN odgovor o ON p.id_pitanje=o.id_pitanje SET aktivnost = :aktiv
            WHERE p.id_pitanje = :id";
            $priprema = $conn -> prepare($upit);
            $priprema -> bindParam("aktiv", $aktivnost);
            $priprema -> bindParam("id", $id);
            $priprema -> execute();

            $message = "Uspšno ste promenili status.";
            header("Location: ../admin.php?page=urediAnketu&message=".$message); 
        }
        catch(PDOException $ex){
            http_response_code(500);
            $error = "Došlo je do greške na serveru. Pokušajte kasnije.";
            header("Location: ../admin.php?page=urediAnketu&error=".$error);
        }
    }
?>