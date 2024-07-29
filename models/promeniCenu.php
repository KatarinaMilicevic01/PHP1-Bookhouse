<?php
    include "../config/connection.php";
    global $conn;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $cena = $_POST['cena'];
        $datum = date("Y-m-d");
        //echo($cena);

        
            $cenaU = "UPDATE cenovnik SET status = 0 WHERE id_knjiga = :id AND status = 1";
            $pripremi = $conn -> prepare($cenaU);
            $pripremi -> bindParam("id", $id);
            $pripremi ->execute();

            $upit = "INSERT INTO cenovnik VALUES (NULL, :id, :cena, :datum, 1)";
            $priprema = $conn -> prepare($upit);
            $priprema -> bindParam("id", $id);
            $priprema -> bindParam("cena", $cena);
            $priprema -> bindParam("datum", $datum);
            $priprema -> execute();

            echo json_encode(['poruka' => 'uspeh']);

    }

?>