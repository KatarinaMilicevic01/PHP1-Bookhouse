$(document).ready(function(){

    //ajaxCallBack
    function ajaxCallBack(url, method, data, result){
        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "JSON",
            success: result,
            error: function(xhr){
                console.log(xhr);
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
                if(result.aktivnost == 1){
                    window.location.href = "index.php?page=pocetna";
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

    //ispis divova na pocetnoj stranici
    function ispisKnjigePocetna(data, div){
        html=`<div class="container-fluid">
        <div class="row">`;
        for(let d of data){
            html += `<div class="col text-center">
                        <a href="index.php?page=knjige&id=${d.id_knjiga}" class="text-decoration-none">
                        <img src="assets/img/${d.slikaMala}" alt="${d.naslov}">
                        <h3>${d.naslov}</h3>
                        <p>${d.ime} ${d.prezime}</p>
                        </a>
                    </div>`;
        };
        $(div).html(html);
    }

    //ispis diva novi naslovi na pocetnoj stranici
    function noviNaslovi(){
        
    }
    
})