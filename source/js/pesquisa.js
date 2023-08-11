var PesqCateg;
var PesqType;
var PesqText;

function Inicializa() {
    PesqCateg = document.getElementById("PesqCateg");
    PesqType = document.getElementById("PesqType");
    PesqText = document.getElementById("PesqText");
}

var searching = false;
function OnWriting(obj) {

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
                            optcontainer.innerHTML += "<p class='option-container'>" + data[i].text + "<br><small><small class='text-muted'>" + small + "</small></small></p>";
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

function Pesquisar() {
    window.location = 'pesquisa';
}