<?php
    if(isset($_GET['id'])){
        
        $id = $_GET['id'];
        global $conn;
        $upit = "SELECT * FROM knjiga k JOIN autor a ON k.id_autor = a.id_autor 
        JOIN povez po ON k.id_povez=po.id_povez JOIN pismo p ON k.id_pismo=p.id_pismo WHERE id_knjiga = :id";
        $priprema = $conn -> prepare($upit);
        $priprema -> bindParam("id", $id);
        try{
            $priprema -> execute();
            $knjiga = $priprema -> fetchAll();
            if($knjiga){
                $knjiga = $knjiga[0];
                
                $upit1 = "SELECT * FROM kategorija k JOIN kategorija_knjiga kk ON k.id_kat = kk.id_kat
                WHERE id_knjiga = :id";
                $priprema1 = $conn -> prepare($upit1);
                $priprema1 -> bindParam("id", $id);
                $priprema1 -> execute();
                $kategorije = $priprema1 -> fetchAll();
            }
            else{
                $knjiga = false;
            }
        }
        catch(PDOException $ex){
            $error = "Greska na serveru. Molimo pokušajte kasnije.";
        }
        try{
            $upit2 = "SELECT ime, prezime, komentar FROM komentar k JOIN korisnik ko ON k.id_korisnik=ko.id_korisnik WHERE id_knjiga=".$id;
            $komentar = $conn -> query($upit2)->fetchAll();
            
            
        }
        catch(PDOException $ex){
            $error = "Greska na serveru. Molimo pokušajte kasnije.";
        }
    }
?>