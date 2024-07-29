<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <h2 class="text-center my-5">Izmeni cenu</h2>
            <p id="err"></p>
        <?php
            global $conn;

            $upit = "SELECT k.naslov, c.cena, k.id_knjiga FROM cenovnik c JOIN knjiga k ON c.id_knjiga=k.id_knjiga WHERE status=1";
            $cene = $conn -> query($upit) -> fetchAll();

            if(isset($_GET['uspeh'])){
                echo '<p>'.$_GET['uspeh'].'</p>';
            }
            if(isset($_GET['error'])){
                echo '<p>'.$_GET['error'].'</p>';
            }

            echo '<table class="table table-dark table-striped my-5">
                    <thead>
                        <tr>
                            <th scope="col">Rb.</th>
                            <th scope="col">Knjiga</th>
                            <th scope="col">Cena</th>
                            <th scope="col"></th>
                        </tr>
                   </thead>
                   <tbody>';
                $rb=1;
            foreach($cene as $c){
                echo'<tr>
                <th scope="row">'.$rb.'</th>
                    <td>'.$c -> naslov.'</td>
                    <td>'.$c -> cena.'</td>
                    <td><button type="button" class="btn btn-primary izmeniCenu" data-id="'.$c->id_knjiga.'" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Izmeni
                  </button></td>
                </tr>';
                $rb++;
            }
            echo '</tbody>
            </table>';
?>
        </div>
    </div>
</div>
<div class="modal fade izmeniCenu" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Izmeni cenu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <input type="hidden" name="knjiga" id="id" class="form-control">
                <input type="text" name="cena" id="cena" class="form-control my-2">
                <button type="button" id="btnCena" data-bs-dismiss="modal" class="btn btn-primary">Izmeni</button>
      </div>
    </div>
  </div>
</div>