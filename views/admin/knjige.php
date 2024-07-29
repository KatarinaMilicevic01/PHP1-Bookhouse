<?php
    include 'models/podaciZaTabelu.php';
?>
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <h2 class="text-center my-4">Lista knjiga</h2></a>
        <div class="col-11">
            <table class="table table-dark table-hover table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Naslovna strana</th>
                        <th scope="col">Naslov</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Broj strana</th>
                        <th scope="col">Datum izdanja</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Povez</th>
                        <th scope="col">Pismo</th>
                    </tr>
                </thead>
                <tbody>
                <?php $rb=1;
                foreach($knjige as $k):?>
                    <tr class="py-5">
                        <th scope="row"><?=$rb?></th>
                        <td style='width:100px; height:70px;'><img src='assets/img/<?=$k->slikaMala?>'></td>
                        <td class="my-5"><?= $k -> naslov ?></td>
                        <td><button type="button" class="btn btn-outline-light" data-bs-toggle="modal" 
                        data-bs-target="#exampleModal<?=$rb?>">Prikaži opis</button></td>
                        <td><?=$k->br_strana?></td>
                        <td><?=$k->datum_izdanja?></td>
                        <td><?=$k->pisac?></td>
                        <td><?=$k->povez?></td>
                        <td><?=$k->pismo?></td>
                    </tr>                    
                <div class="modal modal-dialog-scrollable text-dark" id="exampleModal<?=$rb?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-dark">
                                <h5 class="modal-title text-light" id="exampleModalLabel"><strong>Opis knjige "<?=$k->naslov?>"</strong></h5>
                                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-dark">
                                <?= $k-> opis; $rb++; endforeach?>
                            </div>
                        </div>
                    </div>
                </div>   
                </tbody>
            </table>
       </div>
    </div>
    <div class="row">

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    </div>
</div>