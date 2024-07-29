$(document).ready(function(){

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
    //dodaj cenu
    $(document).on('click', ".izmeniCenu", function(){
        id=$(this).data('id');
        $(".modal-body #id").val(id);
        idKnjiga = $("#id").val();
        console.log(idKnjiga);
        
    })

    function promeniCenu(){
            id = $("#id").val();
            cena = $("#cena").val();
            greska=0;
            console.log(id);
            data = {
                "id": id,
                "cena": cena
            }
            if(id == ""){
                $("#err").addClass("alert alert-danger");
                $("#err").html("Uneti parametri nisu ispravni. Pokušajte ponovo.")
                greska++;
            }
            if(cena == ""){
                $("#err").addClass("alert alert-danger");
                $("#err").html("Uneti parametri nisu ispravni. Pokušajte ponovo.")
                greska++;
            }
            console.log(data);
            if(greska == 0){
                ajaxCallBack("models/promeniCenu.php", "post", data, function(result){
                    console.log(result);
                    if(result.poruka == 'uspeh'){
                        $("#err").removeClass("alert alert-danger");
                        $("#err").addClass("alert alert-success");
                        $("#err").html("Uspešno ste izmenili cenu.");
                    }
                })
            }
            
    }

    $(document).on("click", "#btnCena", promeniCenu);
    
    
})