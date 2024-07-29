<?php 
    if(isset($_SESSION['korisnik'])):
        if($_SESSION['korisnik']->id_uloga == 2):
    
?>
<div class="container-fluid">
        <?php 
            global $conn;

            $id = $_SESSION['korisnik'] -> id_korisnik;
            $glas = "SELECT * FROM anketa WHERE id_korisnik = :id";
            $spremi = $conn -> prepare($glas);
            $spremi -> bindParam("id", $id);
            $spremi -> execute();
            $glasao = $spremi -> fetchAll();
            if(count($glasao) != 0){
                echo '<div class="row d-flex justify-content-around" id="anketa" style="height:80vh;">
                    <h2 class="text-center my-5">Molimo Vas da popunite anketu i pomognete nam da unapredimo poslovanje</h2>
                    <div class="col-5 alert alert-success mx-auto mb-5" role="alert" >
                        <h4 class="alert-heading">Već ste glasali!</h4>
                        <p>Anketa više nije aktivna. Može se popuniti samo jednom. Hvala Vam na interesovanju i izdvojenom vremenu. Obavestićemo Vas kada nova anketa bude aktivna.</p>
                    <hr>
                    <p class="mb-0">Ukoliko imate neke predloge, uvek nas možete kontaktirati 
                    <a href="admin.php?page=kontakt" class="text-decoration-none text-danger">ovde.</a></p>
                    </div>
                    </div>';
            }
            else{
            echo '<div class="row d-flex justify-content-around" id="anketa">
        <h2 class="text-center my-5">Molimo Vas da popunite anketu i pomognete nam da unapredimo poslovanje</h2>';
            $pitanja = "SELECT * FROM pitanja WHERE aktivnost=1";
            $pitanje = $conn -> query($pitanja) -> fetchAll();
            foreach($pitanje as $p){
                $odgovori = "SELECT * FROM odgovor o JOIN pitanja p ON o.id_pitanje=p.id_pitanje WHERE o.id_pitanje=$p->id_pitanje";
                $odgovor = $conn -> query($odgovori) -> fetchAll();
                if($p->id_pitanje == 1){
                    echo '<div class="col-4 mx-5 my-5" style="border: 1px solid bisque">
                            <h4 class="mt-5 mx-5">'.$p->pitanje.'</h4>
                            <div id="rbMsg"></div><hr>';
                            
                    foreach($odgovor as $o){
                        echo '<div class="custom-control custom-radio mx-5">
                                <input type="radio" id="customRadio1" name="anketaRb" class="custom-control-input anketaRb" value="'.$o->odgovori.'">
                                <label class="custom-control-label mb-3" for="customRadio1">'.$o->odgovori.'</label>
                            </div>';
                        }
                    echo '</div>';    
                }
                if($p->id_pitanje == 2){
                    echo '<div class="col-4 mx-5 my-5" style="border: 1px solid bisque" id="cb">
                            <h4 class="mt-5 mx-5">'.$p->pitanje.'</h4>
                            <div id="cbMsg"></div><hr>';
                    foreach($odgovor as $o){
                        echo '<div class="custom-control custom-checkbox mx-5">
                                <input type="checkbox" class="custom-control-input anketaCb" id="customCheck1" value="'.$o->odgovori.'">
                                <label class="custom-control-label mb-3" for="customCheck1">'.$o->odgovori.'</label>
                            </div>';
                    }
                    echo '</div>';
                }
            }       
        
             echo '<p id="poruka"></p>
            <input type="button" value="Pošalji odgovore" id="btnAnketa" class="col-3 btn btn-outline-light mb-5 anketa">';   
        }
    echo'    
        </div>
</div>';
endif; endif;?>