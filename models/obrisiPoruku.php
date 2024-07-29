<?php
    include "../config/connection.php";
    global $conn;

    if(!isset($_GET['id'])){
        header("Location: ../admin.php?page=pocetna");
    }

    $id = $_GET['id'];
    try{
        $brisi = "DELETE FROM poruka WHERE id_poruka = :id";
        $priprema = $conn -> prepare($brisi);
        $priprema -> bindParam("id", $id);
        $priprema -> execute();

        $message = "Uspšno ste obrisali podatke iz baze.";
        header("Location: ../admin.php?page=poruke&message=".$message);
    }
    catch(PDOException $ex){
        $error = "Došlo je do greške na serveru. Pokušajte kasnije.";
        header("Location: ../admin.php?page=poruke&error=".$error);
    }
?>