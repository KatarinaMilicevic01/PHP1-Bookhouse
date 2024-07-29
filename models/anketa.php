<?php
   // session_start();
    include "../config/connection.php";
    global $conn;
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $rbOdg=$_REQUEST['rb'];
        $cbOdgovori[]=$_REQUEST['cb'];
        
        if($rbOdg == 0 || count($cbOdgovori) == 0){
            http_response_code(422);
            json_encode(["error" => "Nisu uneti svi podaci."]);
        }
        else{
            $id = $_SESSION['korisnik'] -> id_korisnik;

            //radioButton odgovori
            $upit1 = "SELECT id_odgovor FROM odgovor WHERE odgovori = :rbOdg";
            $priprema1 = $conn -> prepare($upit1);
            $priprema1 -> bindParam("rbOdg", $rbOdg);
            $priprema1 -> execute();
            $rbOdgovor = $priprema1 -> fetch();

            //checkBox odgovori
            $cbID = [];
            foreach($cbOdgovori[0] as $cb){
                $i = 0;
                $upit3 = "SELECT id_odgovor FROM odgovor WHERE odgovori = :cb";
                $priprema3 = $conn -> prepare($upit3);
                $priprema3 -> bindParam("cb", $cb);
                $priprema3 -> execute();
                $cbOdg = $priprema3 -> fetch();
                $cbID[] = $cbOdg -> id_odgovor;
                $i++;
            }
            
            if($rbOdgovor && count($cbID) != 0){
                $rbId = $rbOdgovor -> id_odgovor;        

                //upis rbOdg u bazu
                $upit2 = "INSERT INTO anketa VALUES (NULL, :idKor, :idOdg)";
                $priprema2 = $conn -> prepare($upit2);
                $priprema2 -> bindParam('idKor', $id);
                $priprema2 -> bindParam('idOdg', $rbId);
                $priprema2 -> execute();

                //upis cbOdg u bazu
                foreach($cbID as $cbId){
                    $upit4 = "INSERT INTO anketa VALUES (NULL, :idKor, :idOdg)";
                    $priprema4 = $conn -> prepare($upit4);
                    $priprema4 -> bindParam('idKor', $id);
                    $priprema4 -> bindParam('idOdg', $cbId);
                    $priprema4 -> execute();
                }
                    if(!$priprema2  && !$priprema4){
                        echo json_encode(["poruka" => "Došlo je do greške prilikom upisa odgovora u bazu. Pokušajte kasnije." , "class" => "danger"]);
                        http_response_code(500);
                    }
                    else{
                        echo json_encode(["poruka" => "Vaši odgovori su uspešno zabeleženi. Hvala na izdvojenom vremenu.", "status" => "uspeh"]);
                        http_response_code(200);
                    }

            }
            else{
                
                http_response_code(422);
            }
        }
    }
?>