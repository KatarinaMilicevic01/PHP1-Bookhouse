<?php
    
    include '../config/connection.php';
    global $conn;

    if(!isset($_GET['id_poruka']) || !isset($_GET['procitano'])){
        header("Location: ../admin.php?page=pocetna");
    }

    $id = $_GET['id_poruka'];
    $procitano = $_GET['status'];
    
    try{
        $izmeni = "UPDATE poruka SET procitano = :procitano WHERE id_poruka = :id";
        $priprema = $conn -> prepare($izmeni);
        $priprema -> bindParam("procitano", $procitano);
        $priprema -> bindParam("id", $id);
        $priprema -> execute();

        $message = "Uspešno ste promenili status.";
        header("Location: ../admin.php?page=poruke&message=".$message);
    }
    catch(PDOException $ex){
        $error = "Došlo je do greške. Pokušajte kasnije.";
        header("Location: ../admin.php?page=poruke&error=".$error);
    }
?>