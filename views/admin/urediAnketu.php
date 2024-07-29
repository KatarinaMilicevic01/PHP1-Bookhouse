<div class="container-fluid">
    <div class="row justify-content-around">
        <?php       $pitanja = "SELECT * FROM pitanja";
                    $pitanje = $conn -> query($pitanja) -> fetchAll();
                    foreach($pitanje as $pita){
                        $idP = $pita -> id_pitanje;
                        $odgovor ="SELECT * FROM odgovor WHERE id_pitanje = $idP";
                        $odgovori = $conn -> query($odgovor) -> fetchAll();
                            echo 
                            '<div class="col-4 my-5">
                                <h4 class="my-5">'.$pita -> pitanje.'</h4>
                                <table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Rb.</th>
                                            <th scope="col">Odgovor</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $rb=1;
                                    foreach($odgovori as $odg){
                                    echo'<tr>
                                            <th scope="row">'.$rb.'</th>
                                            <td>'.$odg -> odgovori.'</td>
                                        </tr>';                                        
                                        $rb++;
                                    }
                                    echo '<tr class="justify-content-center">
                                    <td colspan="2">';        
                                        if($pita -> aktivnost == false){
                                            echo '<a class="col-12 mx-auto text-center my-3 btn btn-success" href="models/izmeniAktivnost.php?aktivnost=1&id='.$pita -> id_pitanje.'">
                                            Aktiviraj</a>';
                                        }
                                        if($pita -> aktivnost == 1){
                                            echo '<a class="col-12 mx-auto text-center my-3 btn btn-danger" href="models/izmeniAktivnost.php?aktivnost=true&id='.$pita -> id_pitanje.'">
                                            Deaktiviraj</a>';
                                        }
                                    echo'</td>
                                    </tr>
                                    </tbody>
                                </table>';                                
                        echo '</div>';}
                        if(isset($_GET['message']))
                                { echo '<p class="alert alert-success mx-5 col-5">'.$_GET['message'].'</p>';}
                            if(isset($_GET['error']))
                                { echo '<p class="alert alert-error mx-5 col-5">'.$_GET['error'].'</p>';}
                        ?>

