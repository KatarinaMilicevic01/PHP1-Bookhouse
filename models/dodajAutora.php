<?php
    include "../config/connection.php";
    global $conn;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];

        if($ime == "" || $prezime == ""){
            header("Location: ../admin.php?page=dodajAutora&greska=greska");
        }

        try{
            $upit = "INSERT INTO autor VALUES (NULL, :ime, :prezime)";
            $priprema = $conn -> prepare($upit);
            $priprema -> bindParam("ime", $ime);
            $priprema -> bindParam("prezime", $prezime);
            $priprema -> execute();

            if($priprema){
                header("Location: ../admin.php?page=dodajAutora&uspeh");
                
            }
            else{
                
                header("Location: ../admin.php?page=dodajAutora&error");
            }
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
?>