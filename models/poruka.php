<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        try{
            include "../config/connection.php";
            global $conn;
            $greske = 0;

            $ime = $_POST['ime'];
            $email = $_POST['email'];
            $naslov = $_POST['naslov'];
            $poruka = $_POST['message'];

            $regIme = "/^[A-ZŠĐŽČĆ][a-zšđžčć]{2,50}$/";
            $regEmail = "/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
            $regNaslov = "/^[\w\s]+$/";

            if(!preg_match($regIme, $ime)){ $greske++;}
            if(!preg_match($regEmail, $email)){ $greske++;}
            if(!preg_match($regNaslov, $naslov)){ $greske++;}
            if(explode(" ", $poruka) < 5){ $greske++;}

            if($greske == 0){
                $datum = date('Y-m-d H:i:s');
                $seen = 0;
                //echo($datum);

                global $conn;
                $upit = "INSERT INTO poruka (ime, email, poruka, datum, procitano) VALUE 
                ( :ime, :email :naslov, :poruka, :datum, :seen)";
                $priprema = $conn -> prepare($upit);
                $priprema -> bindParam("ime", $ime);
                $priprema -> bindParam("email", $email);
                $priprema -> bindParam("naslov", $naslov);
                $priprema -> bindParam("poruka", $poruka);
                $priprema -> bindParam("datum", $datum);
                $priprema -> bindParam("seen", $seen);
                $priprema -> execute();

                //var_dump($priprema);
                echo json_encode(["poruka" => "uspeh"]);
                http_response_code(201);
            }
            else{
            echo json_encode(["poruka" => "podaci"]);
            http_response_code(200);
            }
        }
        catch(PDOException $ex){
            http_response_code(500);
            
        }
    }
?>