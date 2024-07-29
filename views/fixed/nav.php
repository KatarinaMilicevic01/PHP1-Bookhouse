<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container-fluid justify-content-between">
        <?php
            if(isset($_SESSION['korisnik'])){
                if($_SESSION['korisnik']->id_korisnik == 1){
                    echo '<a class="navbar-brand" href="admin.php"><i class="fas fa-user-cog"></i>
                    Admin panel - '.$_SESSION['korisnik']->ime.' </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>';
                }
                else echo'<a class="navbar-brand" href="#"><img src="assets/img/logoNav.png" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>';
            }
            else echo '<a class="navbar-brand" href="#"><img src="assets/img/logoNav.png" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>';
        ?>
        <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
        <ul class="navbar-nav">
        <?php            
            include "models/navigacija.php";
            if(isset($_SESSION['korisnik'])){
                if($_SESSION['korisnik']->id_uloga==2){
            echo '<li class="nav-item">
                <a class="nav-link" href="#" style="color:grey;"><i class="fas fa-user-circle mx-2"></i>'.$_SESSION["korisnik"]->ime.'</a>
            </li>';
                }
            }?>
        </ul>
        </div>
    </div>
    </nav>