<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){   
        
        try{            
            include "../config/connection.php";

            $ime = $_POST['tbIme'];
            $prezime = $_POST['tbPrezime'];
            $email = $_POST['tbEmail'];
            $lozinka = $_POST['tbLozinka'];
            $potvrda = $_POST['tbPotvrda'];

            $greske=0;
            
            $regIme = "/^[A-ZŠĐŽČĆ][a-zšđžčć]{2,50}$/";
            $regPrezime = "/^[A-ZŠĐŽČĆ][a-zšđžčć]{3,50}$/";
            $regEmail = "/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
            $regLozinka = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

            if(!preg_match($regIme, $ime)){
                $greske++;
            }
            if(!preg_match($regPrezime, $prezime)){
                $greske++;
            }
            if(!preg_match($regEmail, $email)){
                $greske++;
            }
            if(!preg_match($regLozinka, $lozinka)){
                $greske++;
            }
            if($lozinka != $potvrda){
                $greske++;
            }
            //echo($greske);
            if($greske == 0 ){
                global $conn;
                $proveriEmail = "SELECT * FROM korisnik WHERE email = :email";
                $priprema = $conn -> prepare($proveriEmail);
                $priprema -> bindParam("email", $email);
                $priprema -> execute();
                $rez = $priprema ->fetchAll();
                $rezultat = $priprema -> rowCount();

                if($rezultat == 1){
                    $error = "Već postoji korisnik sa ovom email adresom. <a href='index.php?page=logovanje' class='ml-2 text-dark'>Prijavi se.</a>";
                    header("Location: ../index.php?page=registracija&error=".$error);   
                }
                else{
                    try{
                        $dodajKorisnika = "INSERT INTO korisnik 
                        VALUES (NULL, :ime, :prezime, :email, :lozinka, 0, :kod, 2)";

                        $lozinka = md5($lozinka);
                        $kod = rand(100000, 999999);

                        $priprema = $conn -> prepare($dodajKorisnika);
                        $priprema -> bindParam("ime", $ime);
                        $priprema -> bindParam("prezime", $prezime);
                        $priprema -> bindParam("email", $email);
                        $priprema -> bindParam("lozinka", $lozinka);
                        $priprema -> bindParam("kod", $kod);
                        $priprema -> execute();
                    
                        $poruka = "Uspešno ste se registrovali. Proverite email.";
                        header("Location: ../index.php?page=registracija&poruka=".$poruka);
                    }   
                    catch(PDOException $e){
                        $error = "Greska prilikom upisa u bazu.";
                        header("Location: ../index.php?page=registracija&error=".$error); 
                    }       
                }
            }
            else{
                var_dump($greske);
                header("Location: ../index.php?page=registracija");
            }
            
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
?>