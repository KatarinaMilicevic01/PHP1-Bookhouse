<?php
    
        include "../config/connection.php";
        global $conn;

        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }

        $search = "";
        if(isset($_GET['search'])){
            $search = $_GET['search'];
        }

        $kategorija = "";
        if(isset($_GET['kategorija'])){
            $kategorija = $_GET['kategorija'];
        }
        

        $limit = 6;
        $offset = ($page - 1) * $limit;
        $ukupnoKnjiga = 0;
        $data['knjige'] = [];

        $upit = "SELECT DISTINCT k.id_knjiga, naslov, slikaMala, ime, prezime FROM knjiga k JOIN kategorija_knjiga kk ON 
        k.id_knjiga = kk.id_knjiga JOIN autor a ON k.id_autor = a.id_autor WHERE naslov LIKE '%$search%' ";

        if($kategorija!=""){
            //var_dump($kategorija);
            $katId = "SELECT id_kat FROM kategorija WHERE naziv_kat = :kat";
            $pripremi = $conn -> prepare($katId);
            $pripremi -> bindParam("kat", $kategorija);
            $pripremi -> execute();
            $kat = $pripremi -> fetch();
            $id= $kat->id_kat; 
            $upit.="AND kk.id_kat = $id ";
        }
            try{
                $knjige = $conn -> query($upit) -> fetchAll();
                if(count($knjige) != 0){
                    $ukupnoKnjiga = count($knjige);
                    $data['brStrana'] = ceil($ukupnoKnjiga/$limit);
                    $upit.= "LIMIT $limit OFFSET $offset";
                    $data['knjige'] = $conn -> query($upit) -> fetchAll();
                    $data['trenutnaStr'] = $page;
                }

            }
            catch(PDOException $ex){
                http_response_code(500);
                $data = "Greska na serveru";
            }
        http_response_code(200);
        echo json_encode($data);
?>