<div class="container-fluid my-5">
    <div class="row">
        <div class="col-6  d-flex flexwrap">
            <div class="col-10 mx-auto">
                <h2>Kontakt informacije</h2>
                <hr>
                <ul id="kontaktList" class="p-0">
                    <li class="py-3 d-flex align-items-center">
                        <span class="mr-4 fas fa-map textmuted" style="color:grey;"></span>
                        <p class="mb-0 mx-3">Kralja Petra 45, Beograd</p>
                    </li>
                    <li class="py-3 d-flex align-items-center">
                        <span class="mr-4 fas fa-fax textmuted" style="color:grey;"></span>
                        <p class="mb-0 mx-3">011/71-55-085</p>
                    </li>
                    <li class="py-3 d-flex align-items-center">
                        <span class="mr-4 fas fa-clock text-muted" style="color: bisque;"></span>
                        <p class="mb-0 mx-3">Radnim danima 9-17h</p>
                    </li>
                    <li class="py-3 d-flex align-items-center">
                        <span class="fas fa-phone mr-3 text-muted"></span>
                        <p class="mb-0 mx-3">011/71-55-055</p>
                    </li>
                    <li class="py-3 d-flex align-items-center">
                        <span class="far fa-envelope-open mr-3 text-muted"></span>
                        <p class="mb-0 mx-3">info@bookstore.com</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-6">
            <div class="col-10 mx-auto">
                <h2>Pošalji nam poruku</h2>
                <form action="" id="poruka">
                <div class="form-group">
                        <input type="text" placeholder="Ime" name="tbIme" id="tbIme" class="form-control">
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group">
                        <input type="email" name="tbEmail" id="tbEmail" placeholder="Email: petar@gmail.com" class="form-control">
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Naslov" name="tbNaslov" id="tbNaslov" class="form-control">
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group">
                        <textarea placeholder="Tekst poruke..." name="tbPoruka" id="tbPoruka" rows="3" class="form-control"></textarea>
                        <p class="text-danger"></p>
                    </div>
                    <input type="button" id="tbSend" value="Pošalji" class="btn btn-outline-light form-control my-5">
                </form>
                <div id="poruka"></div>
            </div>        
        </div>
    </div>
</div>
<hr>
