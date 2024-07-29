$(document).ready(function(){

    //ajaxCallBack
    function ajaxCallBack(url, method, data, result){
        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "JSON",
            success: result,
            error: function(xhr, status, errorMsg){
                //console.log(xhr);
                console.log("poruka:"+errorMsg);
            }
        })
    }

    //trenutna pozicija
    url=location.href;
    if(url.indexOf("index.php?page=registracija") != -1){
        $("#regForm").submit(registracija);
    }
    if(url.indexOf("index.php?page=logovanje") != -1){
        $("#logForm").on('click', '#btnLog', logovanje);
    }
    if(url.indexOf("index.php?page=pocetna") != -1){
        noviNaslovi();
        preporuceniNaslovi();
    }
    if(url.indexOf("index.php?page=knjige") != -1){
        sveKategorije();
        filterKnjiga();
        $("#tbSearch").keyup(filterKnjiga);
    }
    if(url.indexOf('index.php?page=knjigaDetalji') != -1){
        cena();
        $(document).on('click', '#btnKom', komentar);
    }
    if(url.indexOf("index.php?page=kontakt")){
        $("#poruka").on('click','#tbSend', poruka);
    }
    if(url.indexOf("index.php?page=anketa")){
        $("#anketa").on('click', '#btnAnketa', anketa);
    }
    //regularni izrazi
    function validacija(data, regEx, poruka){
            greske=0;

            if(!regEx.test(data.val())){
                data.addClass('border border-3 border-danger');
                data.parent().find("p").html(poruka);
                greske++;
            }
            else{
                data.removeClass('border border-3 border-danger');
                data.parent().find("p").html("");
            }
            return greske;
    }

    //registracija
    function registracija(){

        greske = 0;
        rezultat = true;

        ime = $('#tbIme');
        prezime = $('#tbPrezime');
        email = $('#tbEmail');
        lozinka = $("#tbLozinka");
        potvrda = $("#tbPotvrda");

        imeGreska = "Ime mora početi velikim slovom i imati najmanje 3 slova.";
        prezimeGreska = "Prezime mora početi velikim slovom i imati najmanje 4 slova.";
        emailGreska = "Email nije u odgovarajucem formatu.";
        lozinkaGreska = "Lozinka mora imati minimum 8 karaktera, jedno slovo i jedan broj.";
        potvrdaGreska = "Lozinka se ne podudara.";

        regIme = /^[A-ZŠĐŽČĆ][a-zšđžčć]{2,50}$/;
        regPrezime = /^[A-ZŠĐŽČĆ][a-zšđžčć]{3,50}$/;
        regEmail = /^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
        regLozinka = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        greske+=validacija(ime, regIme, imeGreska);
        greske+=validacija(prezime, regPrezime, prezimeGreska);
        greske+=validacija(email, regEmail, emailGreska);
        greske+=validacija(lozinka, regLozinka, lozinkaGreska);
        if(potvrda.val() == "" || lozinka.val() != potvrda.val()){ 
            potvrda.addClass('border border-3 border-danger');
            potvrda.parent().find("p").html(potvrdaGreska);
            greske++; 
        }
        else{
            potvrda.removeClass('border border-3 border-danger');
            potvrda.parent().find("p").html("");
        }
        if(greske != 0){
            rezultat = false;
        }
        return rezultat;
    }

    //logovanje
    function logovanje(){
        email = $("#tbEmail");
        lozinka = $("#tbLozinka");
        greske=0;

        emailGreska = "Email nije u odgovarajucem formatu.";
        lozinkaGreska = "Lozinka mora imati minimum 8 karaktera, jedno slovo i jedan broj.";

        regEmail = /^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
        regLozinka = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        greske+=validacija(email, regEmail, emailGreska);
        greske+=validacija(lozinka, regLozinka, lozinkaGreska);

        data = {
            email: email.val(),
            lozinka: lozinka.val()
        }

        if(greske==0){
           ajaxCallBack("models/logovanje.php", "post", data, function(result){
            console.log(result.aktivnost);
                if(result.aktivnost == 1 && result.id == 1){
                    window.location.href = "admin.php?page=pocetna";
                }
                if(result.aktivnost == 1 && result.id == 2){
                    window.location.href = 'index.php?page=pocetna';
                }
                if(result.aktivnost == 0){
                    $("#error").addClass('alert alert-danger form-control my-3');
                    $("#error").html("Niste aktivirali nalog. Molimo proverite email.");
                }
                if(result.korisnik == "nema korisnika"){
                    $("#error").addClass('alert alert-danger form-control my-3');
                    $("#error").html("Ne postoji korisnik sa unetim podacima. Proverite podatke.");
                }
           })
        }
    }

    //ispis divova na pocetnoj stranici i na strani sa svim knjigama
    function ispisKnjigePocetna(data, div){
        html=`<div class="container-fluid">
        <div class="row">`;
        for(let d of data){
            html += `<div class="col-3 text-center d-flex justify-content-center knjiga">
                        <a href="index.php?page=knjigaDetalji&id=${d.id_knjiga}" class="text-decoration-none">
                        <img src="assets/img/${d.slikaMala}" alt="${d.naslov}" class="my-3">
                        <h3>${d.naslov}</h3>
                        <p>${d.ime} ${d.prezime}</p>
                        </a>
                    </div>`;
        };
        $(div).html(html);
    }

    //ispis novih naslova
    function noviNaslovi(){
        ajaxCallBack("models/noviNaslovi.php", "get", "", function(result){
            ispisKnjigePocetna(result, "#noviNaslovi")
        })
    }

    //ispis preporucenih naslova
    function preporuceniNaslovi(){
        ajaxCallBack("models/preporuceniNaslovi.php", "get", "", function(result){
            ispisKnjigePocetna(result, "#preporuceno");
        })
    }

    //dohvati sve kategorije
    function sveKategorije(){
        ajaxCallBack("models/sveKategorije.php", "get", "", function(result){
            ispisKat(result);
        })
    }

    //ispis kategorija
    function ispisKat(data){
        html="";
        for(let d of data){
            html+=`<a href="#" class="text-decoration-none kategorija">${d.naziv_kat}</a></br>`;
        }
        $("#kategorije").html(html);
        $(".kategorija").click(filterKnjiga);
        $(".kategorija").click(function(){ 
            $(".activeKat").removeClass("activeKat");
            $(this).addClass('activeKat')});
    }

    //ispis filtriranih knjiga
    function ispisiSveKnjige(data, div){
        html='<div class="row">';
        for(let d of data){
            html+=`<div class="col-4 text-center d-flex justify-content-center knjiga">
                <a href="index.php?page=knjigaDetalji&id=${d.id_knjiga}" class="text-decoration-none">
                <img src="assets/img/${d.slikaMala}" alt="${d.naslov}" class="my-3">
                <h3>${d.naslov}</h3>
                <p>${d.ime} ${d.prezime}</p>
                </a>
                </div>`;
        }
        html+='</div>';
        $(div).html(html);
    }

    //dohvatanje filtriranih knjiga
    function filterKnjiga(){
        search = $("#tbSearch").val();
        kat= $(this).text();
        console.log(kat);

        data={
            search: search,
            kategorija: kat
        }
        ajaxCallBack("models/sveKnjige.php", "get", data, function(result){
            console.log(result);
            if(result.knjige.length != 0){
                ispisiSveKnjige(result.knjige, "#sveKnjige");
                paginacija(result);
            }
            else{
                $("#sveKnjige").html("<p class='text-center'>Ne postoji tražena knjiga.</p>");
            }
        })
    }

    //paginacija
    function paginacija(data){
        html=`<nav aria-label="paginacija">
        <ul class="pagination text-color-black">
        <li class="page-item`;
            if(data.trenutnaStr == 1){
                html+=" disabled";
            }
        html+=`"><a class="page-link" href="#" data-id="${data.trenutnaStr-1}">Prethodna</a></li>`;
        if(data.brStrana != 1){
            for(let i = 1; i <= data.brStrana; i++){
                html+=`<li class="page-item`;
                if(i == data.trenutnaStr){
                    html+=` active`;
                }
                html+=`"><a class="page-link" href="#" data-id="${i}">${i} </a></li>`;
            }
        }
        html+=`<li class="page-item`;
            if(data.trenutnaStr == data.brStrana){
                html+=` disabled`;
            }
        html+=`"><a class="page-link" href="#" data-id="${data.trenutnaStr+1}">Next</a>
            </li>
            </ul>
            </nav>`;
        $("#paginacija").html(html);
        $(".page-link").click(drugaStrana);
    }
    
    
    //promeni stranicu
    function drugaStrana(e){
        e.preventDefault(e);
        search = $("#tbSearch").val();
        strana = $(this).attr("data-id");
        console.log(strana);
        kategorija = $(".activeKat").text();
        console.log(kategorija);

        data={
            search: search,
            page: strana,
            kategorija: kategorija
        }
        ajaxCallBack("models/sveKnjige.php", "get", data, function(result){
            console.log(result);
            if(result.knjige.length != 0){
                ispisiSveKnjige(result.knjige, "#sveKnjige");
                paginacija(result);
            }
            else{
                $("#sveKnjige").html("<p class='text-center'>Ne postoji tražena knjiga.</p>");
            }
        })
    }

    //ispis diva za cenu knjige
    function cena(){
        id = url.split("=");
        data = {id : id[2]};
    
        html=``;
        ajaxCallBack("models/cena.php", "get", data, function(result){
            console.log(result);
            html+=`<h3 class="mx-3 my-2">Cena:</h3>
            <hr>
            <p class="mx-3">Cena: <strong>`;
            if(result.popust.length != 0){
                for(let r of result.popust){
                        html+=`${r.cena_sa_popustom} din</strong><small class="mx-3"><del>${result.cena} din</del></small></p>
                        <p class="mx-3">Ušteda: <strong>${result.cena - r.cena_sa_popustom} din</strong></p>
                        <p class="mx-3">Akcija: <strong>${r.naziv_popust}</strong></p><hr>`;
                    }
            }
            else{
                console.log("cao");
                html+=`${result.cena} din</strong></p>
                    <p class="mx-3">Sa članskim popustom: 
                    <strong>${parseFloat(result.cena-(result.cena*30/100)).toFixed(2)} din</strong></p>
                    <hr>`;
            }
            html+=`<p class="mx-3"><small>Trenutno nije moguće online naručivanje</small></p>`;
            $("#cenaKnjige").html(html);
        })
    }

    //poruka
    function poruka(){
        greska=0;

        ime = $("#tbIme");
        email = $("#tbEmail");
        naslov = $('#tbNaslov');
        text = $("#tbPoruka");
        mssg =text.val().trim().split(" ");

        imeGreska = "Ime mora početi velikim slovom i imati najmanje 3 slova.";
        emailGreska = "Email nije u odgovarajucem formatu.";
        naslovGreska = "Ovo je obavezno polje, ne sme biti prazno.";

        regIme = /^[A-ZŠĐŽČĆ][a-zšđžčć]{2,50}$/;
        regEmail = /^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
        regNaslov=/^[\w\s]+$/;

        greska+=validacija(ime, regIme, imeGreska);
        greska+=validacija(email, regEmail, emailGreska);
        greska+=validacija(naslov, regNaslov, naslovGreska);
        if(text.val() == "" || mssg.length < 5){
            text.addClass('border-danger');
            text.parent().find('p').html("Poruka mora sadržati najmanje 5 reči.");
            greska++;
        }
        else{
            text.removeClass('border-danger');
            text.parent().find('p').html("");
        }

        data = {
            ime: ime.val(), 
            email: email.val(), 
            naslov: naslov.val(), 
            message: text.val()
        }

        if(greska == 0){
            ajaxCallBack('models/poruka.php', "post", data, function(result){
                console.log(result);
                if(result.poruka == "uspeh"){
                    $("#poruka").addClass('alert alert-success form-control my-3');
                    $("#poruka").html("Poruka je poslata.");                    
                }
                if(result.poruka == "podaci"){
                    $("#poruka").addClass('alert alert-danger form-control my-3');
                    $("#poruka").html("Uneti podaci nisu ispravni.");
                }
                if(result.poruka == "server"){
                    $("#poruka").addClass('alert alert-danger form-control my-3');
                    $("#poruka").html("Greska na serveru. Pokusajte kasnije.");
                }
            })
        }
    }

    function anketa(){
        cbOdg= new Array();

        $("#cb input:checked").each(function(){cbOdg.push(this.value)});
        rbOdg = $("input[name='anketaRb']:checked").val();

        obavestenje = `<div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
          Obavezno je odgovoriti na ovo pitanje.
        </div>
      </div>`;

        if(!rbOdg){
            $("#rbMsg").html(obavestenje);
        }
        else{
            $("#rbMsg").html("");
        }
        if(cbOdg.length == 0){
            $("#cbMsg").html(obavestenje);
        }
        else{
            $("#cbMsg").html("");
        }

        data = {
            rb: rbOdg,
            cb: cbOdg
        }
        console.log(data);
        ajaxCallBack("models/anketa.php", "post", data, function(result){
            console.log(result);
            console.log(result.poruka);
            console.log(result.class);
            if(result.status == "uspeh"){
                $("#btnAnketa").hide();
                $("#poruka").addClass("alert alert-success col-4 mx-auto");
            }
            if(result.status == "error"){
                $("#poruka").addClass("alert alert-danger col.4 mx-auto");
            }
            $("#poruka").html(result.poruka);
            console.log(("'alert alert-"+result.class+"'"))
        })
    
    }

    function komentar(){
        kom=$('#komentar');
        id = url.substr(-1);
        if(kom.val() == ""){
            kom.addClass('border border-3 border-danger');
            $("#komm").html("Unesite komentar.");
        }
        data = {
            kom:kom.val(),
            id:id
        };
        ajaxCallBack("models/komentar.php", "get", data, function(result){
            console.log(result);
            if(result.poruka == "uspeh"){
                $("#komm").addClass("alert alert-success");
                $("#komm").removeClass('text-danger');
                $("#komm").html("Vaš komentar je zabeležen.");
            }
        })
    }

})