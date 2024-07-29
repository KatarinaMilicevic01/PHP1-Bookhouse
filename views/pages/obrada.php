<div class="container fluid">
  <div class="row d-flex justify-content-center align-item-center my-5" style="height:65vh;">
<?php
    global $conn;

    if(isset($_GET['kod']) && isset($_GET['email'])){

      try{
        $email=$_GET['email'];
        $kod = $_GET['kod'];
        $upit = "UPDATE korisnik SET status=1 WHERE email=:email AND kod=:kod";
        $priprema = $conn -> prepare($upit);
        $priprema -> bindParam("email", $email);
        $priprema -> bindParam("kod", $kod);
        $priprema -> execute();

        if($priprema -> rowCount() == 1){
        echo '
        <div class="col-5 alert alert-success mx-auto mb-5 my-5" role="alert" style="height:35vh;">
            <h4 class="alert-heading">Čestitamo!</h4>
            <p>Vaš nalog je uspešno verifikovan. Sada možete nastaviti sa korišćenjem sajta!</p>
        <hr>
        <p class="mb-0">Ukoliko imate bilo kakvo pitanje, uvek nas možete kontaktirati 
        <a href="admin.php?page=kontakt" class="text-decoration-none text-danger">ovde.</a></p>
        </div>
        </div>';
        }
      }
      catch(PDOException $ex){
        echo '<div class="container-fluid">
        <div class="row d-flex justify-content-center" style="height:80vh;">
              <h1 class="text-center my-5">Greška sa serverom.</h1>
        </div>
        </div>';
     }
   }
    else{
      echo '<div class="container-fluid">
        <div class="row d-flex justify-content-center" style="height:80vh;">
              <h1 class="text-center my-5">Nemate pravo pristupa ovoj stranici.</h1>
        </div>
        </div>';
    }
    
?>
</div>
</div>
