<?php
unset($_SESSION['korisnik']);
    include "config/connection.php";

    $page = "pocetna";
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }

    if(!file_exists("views/pages/$page.php")){
        header("Location: index.php?page=pocetna");
    }

    include "views/fixed/head.php";
    include "views/fixed/nav.php";

    //MAIN CONTENT


    require_once "views/pages/$page.php";
    include "views/fixed/footer.php";

?>