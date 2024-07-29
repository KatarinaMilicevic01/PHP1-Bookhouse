<?php
    include 'models/podaciZaTabelu.php';
?>
<div class="row d-flex justify-content-center">
        <h2 class="text-center my-4">Lista poruka</h2></a>
        <div class="col-11">
            <table class="table table-light table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ime</th>
                        <th scope="col">Email</th>
                        <th scope="col">Naslov</th>
                        <th scope="col">Poruka</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Pročitano</th>
                        <th scope="col">Obriši</th>
                    </tr>
                </thead>
                <tbody>
                <?php $rb=1;
                foreach($poruke as $p):?>
                    <tr class="<?=$p -> procitano == 1 ? "table-secondary" : "table-primary"?>">
                        <th scope="row"><?=$rb?></th>
                        <td><?=$p->ime?></td>
                        <td class="my-5"><?= $p -> email ?></td>
                        <td><?=$p->naslov?></td>
                        <td><?=$p->poruka?></td>
                        <td><?=$p->datum?></td>
                        <td><a href="models/promeniStatusPoruke.php?id_poruka=<?=$p->id_poruka?>&status=
                        <?=$p -> procitano == 1 ? "0" : "1"?>"
                        class="btn btn-<?=$p->procitano == 1 ? "secondary" : "primary"?>">
                        <?=$p -> procitano == 1 ? "Označi kao nepročitano" : "Označi kao pročitano"?></a></td>
                        <td><a href="models/obrisiPoruku.php?id=<?=$p -> id_poruka?>" class="btn btn-danger">Obriši</a></td>
                    </tr>  
                    <?php endforeach;?>                  
                </tbody>
            </table>
       </div>
       <?php
            if(isset($_GET['message']))
                { echo '<p class="alert alert-success mx-5 my-4 col-5">'.$_GET['message'].'</p>';}
            if(isset($_GET['error']))
                { echo '<p class="alert alert-error mx-5 my-4 col-5">'.$_GET['error'].'</p>';}
       ?>
</div>