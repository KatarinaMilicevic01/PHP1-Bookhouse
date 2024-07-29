<div class="container-fluid">
        <?php
            global $conn;

            $pitanja = "SELECT * FROM pitanja";
            $pitanje = $conn -> query($pitanja) -> fetchAll();
            foreach($pitanje as $pita){
                $pId = $pita -> id_pitanje;
                echo '<h3 class="text-center my-5">'.$pita -> pitanje.'</h3>
                <div class="row justify-content-center mb-5 bg" id="GlDiv">
                    <div class="col-3 text-dark bg-clr">';
                    $odgovor = "SELECT * FROM odgovor WHERE id_pitanje = $pId";
                    $odgovori = $conn -> query($odgovor) -> fetchAll();
                    $ukupnoOdg = count($odgovori);
                    foreach($odgovori as $odg){
                        echo  '<p>'.$odg -> odgovori.'</p>';
                    }
                    
                    echo 
                    '</div>
                    <div class="col-5 bg-clr" id="divRod">';
                    foreach($odgovori as $odg){
                        $idOdg = $odg -> id_odgovor;
                        $brojOdg = "SELECT * FROM anketa WHERE id_odgovor = ".$idOdg;
                        $brOdg = $conn -> query($brojOdg) -> fetchAll();
                        $procenat = count($brOdg) * 100 / $ukupnoOdg; 
                        if($odg -> id_pitanje == 1){
                        echo '<div class="progress bg-clr">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: '.($procenat+5).'%; height: 100% !important;" aria-valuenow="'.$procenat.'" aria-valuemin="0" aria-valuemax="100">'.count($brOdg).'</div>
                             </div>';
                        }
                        else{
                            echo '<div class="progress bg-clr">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: '.($procenat+5).'%" aria-valuenow="'.count($brOdg).'" aria-valuemin="0" aria-valuemax="'.$ukupnoOdg.'">'.count($brOdg).'</div>
                             </div>';
                        }
                    }
            echo '</div>
            <div id="kraj"></div>
                    </div>';    
            } ?>
</div>