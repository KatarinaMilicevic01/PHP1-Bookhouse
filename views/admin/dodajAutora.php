<div class="container-fluid" style="height:80vh;">
    <div class="row d-flex justify-content-center">
        <div class="col-5">
            <h2 class="my-5">Dodaj autora</h2>
            <form action="models/dodajAutora.php" method="POST">
                <div class="form-group">
                    <input type="text" name="ime" id="ime" placeholder="Ime" class="form-control my-3">
                </div>
                <div class="form-group">
                    <input type="text" name="prezime" id="prezime" placeholder="Prezime" class="form-control my-3">
                </div>
                <input type="submit" value="Dodaj autora" class="btn btn-outline-light col-5">
                <?php
                    if(isset($_GET['greska'])){
                        echo '<p class="alert alert-danger my-3">Sva polja su obavezna.</p>';
                    }
                    if(isset($_GET['error'])){
                        echo '<p class="alert alert-danger my-3">Došlo je do greške prilikom upisa u bazu.</p>';
                    }
                    if(isset($_GET['uspeh'])){
                        echo '<p class="alert alert-success my-3">Uspešno ste dodali autora.</p>';
                    }
                ?>
            </form>
        </div>
    </div>
</div>