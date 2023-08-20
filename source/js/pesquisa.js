var PesqCateg;
var PesqType;
var PesqText;
var BtnPesq;

var escreveu = true;

function OnWriting(obj) {

    escreveu = true;

    var optcontainer = document.getElementById("options-container");

    if (obj.value.length > 5) {

        var info = {
            'search': PesqText.value,
        };

        var ajax1 = $.ajax({
            url: "source/sys/forms/endereco.php",
            type: 'POST',
            data: info,
            dataType: 'json',
            async: true,
        })
                .done(function (data) {
                    console.log(data);
                    if (data.length > 0) {

                        optcontainer.innerHTML = "";
                        for (var i = 0; i < data.length; i++) {
                            let small = "";
                            switch (data[i].type) {
                                case 1:
                                    small = "Rua";
                                    break;
                                case 2:
                                    small = "Bairro";
                                    break;
                                case 3:
                                    small = "Cidade";
                                    break;
                                case 4:
                                    small = "Cidade";
                                    break;
                            }
                            optcontainer.innerHTML += "<p onclick=\"DefiniFiltro('" + data[i].text + "','" + data[i].type + "');\" class='option-container'>" + data[i].text + "<br><small><small class='text-muted'>" + small + "</small></small></p>";
                        }

                        optcontainer.classList.add('show');
                        optcontainer.classList.remove('noshow');
                    } else {
                        optcontainer.innerHTML = "";
                        optcontainer.classList.add('noshow');
                        optcontainer.classList.remove('show');
                    }
                })
                .fail(function (jqXHR, textStatus, data) {
                });

    } else {
        optcontainer.innerHTML = "";
        optcontainer.classList.add('noshow');
        optcontainer.classList.remove('show');
    }
}

function DefiniFiltro(txt, typ) {
    escreveu = false;
    PesqText.value = txt;
    var optcontainer = document.getElementById("options-container");
    optcontainer.innerHTML = "";
    optcontainer.classList.add('noshow');
    optcontainer.classList.remove('show');
    PesqCateg.disabled = true;
    PesqType.disabled = true;
    PesqText.disabled = true;
    BtnPesq.disabled = true;
    BtnPesq.innerHTML = "";
    BtnPesq.innerHTML += "<span class='spinner-border spinner-border-sm' aria-hidden='true'></span>";
    BtnPesq.innerHTML += "<span class='visually-hidden' role='status'>Loading...</span>";
    setTimeout(() => {
        Pesquisar(typ);
    }, "1000");
}

function Pesquisar(typ = 0) {
    if (PesqText.value.length > 0) {
        let FilCatg = PesqCateg.value;
        let FilType = PesqType.value;
        let FilTxt = PesqText.value;
        let FilMod = typ;

        if (escreveu) {
            FilMod = 0;
        }

        let FilBigString = "catg###" + FilCatg + "$$$type###" + FilType + "$$$text###" + FilTxt + "$$$mod###" + FilMod;
        var utf8String = unescape(encodeURIComponent(FilBigString));
        var base64String = btoa(utf8String);

        var urlatt = window.location.href;
        var arUrl = urlatt.split("pesquisa");
        arUrl[0] = arUrl[0].replace("index.php", "");
        arUrl[0] = arUrl[0].replace("index", "");
        window.location = arUrl[0] + 'pesquisa/' + base64String;
        $('#ModalLoading').modal('show');
    }
}

document.addEventListener("keydown", function (event) {
    if (event.keyCode === 13 && document.activeElement === PesqText) {
        event.preventDefault();
        Pesquisar();
    }
});

$(document).ready(function () {
    PesqCateg = document.getElementById("PesqCateg");
    PesqType = document.getElementById("PesqType");
    PesqText = document.getElementById("PesqText");
    BtnPesq = document.getElementById("btnpesq");
});