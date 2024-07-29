<?php
    include "models/knjigaDetalji.php";
?>
<div class="container-fluid my-5" style="line-height:0.5em;">
    <div class="row">
        <?php if($knjiga == false):?>
            <div class="col-12" style="height:65vh;">
                <p class="text-center my-5">Knjiga ne postoji. Pokušajte sa nekom drugom knjigom.</p>
            </div>
        <?php else:?>            
            <div class="col-3 text-center">
                <img src="assets/img/<?=$knjiga->slika?>" alt="<?= $knjiga->naslov?>" class="my-3">
                <p><strong>Broj strana: </strong><?= $knjiga->br_strana?></p>                
                <p><strong>Pismo: </strong><?= $knjiga->pismo?></p>
                <p><strong>Povez: </strong><?= $knjiga->povez?></p>
                <p><strong>Datum izdavanja: </strong><?=date("d. m. Y.", strtotime($knjiga->datum_izdanja))?> godine</p>
            </div>
            <div class="col-6 my-3" style="border-right: 1px solid bisque;">
                <h3><strong><?=$knjiga->naslov?></strong></h3>
                <h5><?=$knjiga->ime?> <?=$knjiga->prezime?></h5>
                <p><strong>Kategorije:</strong></p>
                <p><?php
                    $kat=[];
                    foreach($kategorije as $k){
                        $kat[] = $k->naziv_kat;
                    }
                    echo implode(" / ", $kat);
                ?></p>
                <hr class="my-5">
                <p><strong>Opis</strong></p>
                <p class="my-3" style="line-height:1.5em;" id="opis"><?= $knjiga->opis?></p>
            </div>
           <div class="col-3 my-3 d-flex justify-content-center">
                <div id="cenaKnjige" class="row mx-1 border border-secondary position-relative" style="line-height:1em; height:40vh;">
                </div>             
            </div>        
                         
            <hr class="my-5">
                <p><strong>Komentari</strong></p>
                <div class="row d-flex jusify-content-between">  
                    <div class="col-6">
                    <?php if(count($komentar) != 0){                        
                            foreach($komentar as $k){
                                echo '<div class="col border-bottom mt-5">
                                        <p><em>"'.$k->komentar.'"</em></p>
                                        <p><small>'.$k->ime.' '.$k->prezime.'</small></p>
                                </div>';
                            }
                            echo '</div>';
                        }
                        else{
                            echo '<h3>Ne postoji komentar za ovu knjigu.</h3></div>';
                        } 
                        if(isset($_SESSION['korisnik'])){
                            if($_SESSION['korisnik']->id_uloga == 2){
                                echo '<div class="col">';
                                echo '<textarea name="komentar" id="komentar" class="col-12 form-control" rows="8" placeholder="Ostavite svoj komentar.."></textarea>
                                <p class="text-danger my-3" id="komm"></p>
                                <input type="button" value="Posalji" id="btnKom" class="col-3 my-4 btn btn-outline-light"></div>';
                            }
                        }
                        endif;?>
                </div>
    </div>
</div>