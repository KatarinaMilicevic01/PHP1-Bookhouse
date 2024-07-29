<?php

    include "../config/connection.php";
    global $conn;

    if(isset($_GET['id'])){
        
        $id = $_GET['id'];
        try{
            $upit=" SELECT cena FROM cenovnik c JOIN knjiga k ON c.id_knjiga=k.id_knjiga WHERE k.id_knjiga=$id";
            $rezultat = $conn -> query($upit) -> fetchAll();
            $data['cena'] = $rezultat[0]->cena;
            $data['popust'] = [];

            $upit1 = "SELECT naziv_popust, cena_sa_popustom, vrednost_popusta FROM knjiga k JOIN popust_knjiga pk
            ON k.id_knjiga=pk.id_knjiga JOIN popust p ON pk.id_popust=p.id_popust WHERE k.id_knjiga=$id";
            $data['popust']= $conn -> query($upit1) -> fetchAll();
    
            http_response_code(200);
            echo json_encode($data);
        }    
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
   
?>