        <?php
            // session_start();
            // include '../config/connection.php';
            if(isset($_SESSION['korisnik'])){
                $korisnik = $_SESSION['korisnik'];
                if($korisnik -> id_uloga == 1){

                    function dropdown($roditelj){
                        global $conn;
                        $upit = "SELECT * FROM meni WHERE id_uloga=1 AND roditelj=$roditelj";
                        $linkovi = $conn -> query($upit);

                        if($linkovi -> rowCount() > 0){
                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        }
                        foreach($linkovi as $link){
                            echo '<a class="dropdown-item" id="link'.$link->id_meni.'" href="'.$link->putanja.'">'.$link->naziv.'</a>';
                            dropdown($link->id_meni);
                        }
                        if($linkovi -> rowCount() > 0){
                            echo '</div>';
                        }
                    }
                    global $conn;
                    $upit1 = "SELECT * FROM meni WHERE roditelj=0 AND id_uloga=1 AND putanja='#'";
                    $link = $conn -> query($upit1);
                    foreach($link as $l){
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="'.$l->putanja.'" id="navbarDropdown" role="button" aria-haspopup="true" 
                        aria-expanded="false">'.$l->naziv.' </a>';
                        dropdown($l->id_meni);
                        echo '</li>';
                    }
                }
            }
            global $conn;
            $upit2="SELECT * FROM meni WHERE roditelj=0 AND ";
            if(!isset($_SESSION['korisnik'])){
                $upit2.="status_logovanja=0";
            }      
            else{
                
                $korisnik = $_SESSION['korisnik'];
                if($korisnik->id_uloga == 2){
                    $upit2.="id_uloga=2";

                }
                if($korisnik->id_uloga == 1){
                    $upit2.="putanja NOT LIKE '#' AND putanja NOT LIKE 'index.php?page=anketa' AND status_logovanja=1";
                }
            }
            $rezultat = $conn -> query($upit2) -> fetchAll();
            foreach($rezultat as $r){
                echo '<li class="nav-item">
                <a class="nav-link" href="'.$r->putanja.'">'.$r->naziv.'</a>
            </li>';
            }
        ?>