<div class="admin" >
<?php
    // if(isset($_SESSION['korisnik'])){
        //if($_SESSION['korisnik'] -> id_uloga == 1){
            include "config/connection.php";

            $page = "pocetna";
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }

            if(!file_exists("views/admin/$page.php")){
                header("Location: admin.php?page=pocetna");
            }
            

            include "views/fixed/head.php";
            include "views/fixed/nav.php";

            //MAIN CONTENT


            require_once "views/admin/$page.php";
            include "views/fixed/footer.php";
    //     }
    // }
?>
</div>
