const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
const nameRegex = /^[A-Za-zÀ-ÿ\s]+$/;
const phoneNumberMask = "(__) _ ____-____";
const phoneNumberMask2 = "(__) ____-____";

var signin = true;

function OnInput(obj) {

    let value = obj.value.trim();
    obj.classList.remove("is-invalid");

    switch (obj.id) {
        case "RegisterEmail":
            obj.value = obj.value.replace(/[^a-zA-Z0-9._@-]/g, "");
            obj.value = obj.value.toLowerCase();
            obj.value = obj.value.substring(0, 100);
            break;
        case "RegisterName":
            obj.value = obj.value.replace(/[^a-zA-Z0-9áàâãéèêíïóôõöúçÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇ._@-\s]/g, "");
            obj.value = capitalizeWords(obj.value);
            obj.value = obj.value.substring(0, 150);
            break;
        case "RegisterTel":
            let numb = obj.value.replace(/\D/g, "");

            if (numb.length == 10) {
                var formattedMask = phoneNumberMask2;
            } else {
                var formattedMask = phoneNumberMask;
            }

            for (let i = 0; i < numb.length && i < 11; i++) {
                formattedMask = formattedMask.replace("_", numb[i]);
            }

            obj.value = formattedMask;
            obj.value = obj.value.replace(/_/g, "");
            if (numb.length < 8) {
                obj.value = obj.value.replace(/-/g, "");
                obj.value = obj.value.replace(/\s/g, "");
                if (numb.length < 3) {
                    obj.value = obj.value.replace(/[()]/g, "");
                }
            }
            obj.value = obj.value.substring(0, 16);
            break;
    }
}

function OnChange(obj) {
    let value = obj.value.trim();
    obj.classList.remove("is-invalid");

    switch (obj.id) {
        case "RegisterEmail":
            if (!emailRegex.test(value)) {
                obj.classList.add("is-invalid");
                console.log("Email inválido");
            }
            break;
        case "RegisterName":
            if (!nameRegex.test(value)) {
                obj.classList.add("is-invalid");
                console.log("Nome inválido");
            }
            break;
        case "RegisterTel":
            break;
    }
}

function OpenModalLoad() {
    $('#ModalLoading').modal('show');
}
function CloseModalLoad() {
    const intervalo = setInterval(() => {
        console.log("Verificando modal");
        if ($('#ModalLoading').is(':visible')) {
            $('#ModalLoading').modal('hide');
        } else {
            clearInterval(intervalo);
        }
    }, 500);
}

function FazerLogin() {

    OpenModalLoad();

    console.group("Função Login");

    try {

        if (document.getElementById("InputEmail").value.length == "") {
            document.getElementById("InputEmail").classList.add("is-invalid");
            throw new Error("E-mail vazio");
        }

        if (document.getElementById("InputPassword").value.length == "") {
            document.getElementById("InputPassword").classList.add("is-invalid");
            throw new Error("Senha vazia");
        }

        var info = {
            'email': document.getElementById("InputEmail").value,
            'senha': document.getElementById("InputPassword").value,
        };

        var ajax1 = $.ajax({
            url: "source/sys/forms/valid-login.php",
            type: 'POST',
            data: info,
            dataType: 'json',
            async: true,
            beforeSend: function () {
                console.log("Validando Login...");
            }
        })
                .done(function (data) {
                    console.log(data);
                    if (data.status) {
                        document.location.reload(true);
                    } else {
                        CloseModalLoad();
                        console.error(data.mensagem);
                        ExibirMsg("E", data.mensagem);
                    }

                })
                .fail(function (jqXHR, textStatus, data) {
                    CloseModalLoad();
                    console.error(jqXHR['responseText']);
                    ExibirMsg("E", jqXHR['responseText']);
                });

    } catch (e) {
        console.log(e);
        CloseModalLoad();
        ExibirMsg("E", e);
    }

    console.groupEnd();
}

function CriarLogin() {

    OpenModalLoad();

    console.group("Criar Login");

    try {

        if (document.getElementById("RegisterEmail").value.length == "") {
            document.getElementById("RegisterEmail").classList.add("is-invalid");
            throw new Error("E-mail vazio");
        }

        if (document.getElementById("RegisterName").value.length == "") {
            document.getElementById("RegisterName").classList.add("is-invalid");
            throw new Error("Nome vazio");
        }

        if (document.getElementById("RegisterTel").value.length == "") {
            document.getElementById("RegisterTel").classList.add("is-invalid");
            throw new Error("Telefone vazio");
        }

        if (document.getElementById("RegisterPassword").value.length == "") {
            document.getElementById("RegisterPassword").classList.add("is-invalid");
            throw new Error("Senha vazia");
        }

        if (document.getElementById("RegisterConfirm").value.length == "") {
            document.getElementById("RegisterConfirm").classList.add("is-invalid");
            throw new Error("Confirmação de senha vazia");
        }

        var info = {
            'email': document.getElementById("RegisterEmail").value,
            'senha': document.getElementById("RegisterPassword").value,
            'nome': document.getElementById("RegisterName").value,
            'telef': document.getElementById("RegisterTel").value,
        };

        var ajax1 = $.ajax({
            url: "source/sys/forms/create-login.php",
            type: 'POST',
            data: info,
            dataType: 'json',
            async: true,
            beforeSend: function () {
                console.log("Criando Login...");
            }
        })
                .done(function (data) {
                    console.log(data);
                    if (data.status) {
                        document.location.reload(true);
                    } else {
                        CloseModalLoad();
                        console.error(data.mensagem);
                        ExibirMsg("E", data.mensagem);
                    }
                })
                .fail(function (jqXHR, textStatus, data) {
                    CloseModalLoad();
                    console.error(jqXHR['responseText']);
                    ExibirMsg("E", jqXHR['responseText']);
                });

    } catch (e) {
        console.log(e);
        CloseModalLoad();
        ExibirMsg("E", e);
    }

    console.groupEnd();
}

function capitalizeWords(inputString) {
    return inputString.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

document.addEventListener("keydown", function (event) {
    if (event.keyCode === 13) {
        if (signin) {
            FazerLogin();
        } else {
            CriarLogin();
        }
    }
});
