<?php
    session_start();
    header("Content-type: application/json");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        try{
            include "../config/connection.php";
            $greske=0;

            $email = $_POST['email'];
            $lozinka = md5($_POST['lozinka']);

            $regEmail = "/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
            $regLozinka = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

            if(!preg_match($regEmail, $email)){
                $greske++;
            }
            if(!preg_match($regLozinka, $lozinka)){
                $greske++;
            }

            if($greske == 0){
                global $conn;
                $upit = "SELECT * FROM korisnik WHERE email = :email AND lozinka = :lozinka";
                $priprema = $conn -> prepare($upit);
                $priprema -> bindParam("email", $email);
                $priprema -> bindParam("lozinka", $lozinka);
                $priprema -> execute();
                $korisnik = $priprema -> fetch();
                //var_dump($korisnik);
                if($korisnik){
                    if($korisnik -> status == 1){
                        $_SESSION['korisnik'] = $korisnik;                 
                    }                    
                    echo json_encode(["aktivnost" => $korisnik -> status, "id" => $korisnik -> id_uloga]);
                }
                else{
                    $odg = ["korisnik" => "nema korisnika"];
                    echo json_encode($odg);
                }
                http_response_code(200);
            }
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
?>