var InputEmail;
var InputPassword;

var RegisterEmail;
var RegisterName;
var RegisterTel;
var RegisterPassword;
var RegisterConfirm;

const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
const nameRegex = /^[A-Za-zÀ-ÿ\s]+$/;
const phoneNumberMask = "(__) _ ____-____";
const phoneNumberMask2 = "(__) ____-____";

function Inicializa() {
    InputEmail = document.getElementById("InputEmail");
    InputPassword = document.getElementById("InputPassword");

    RegisterEmail = document.getElementById("RegisterEmail");
    RegisterName = document.getElementById("RegisterName");
    RegisterTel = document.getElementById("RegisterTel");
    RegisterPassword = document.getElementById("RegisterPassword");
    RegisterConfirm = document.getElementById("RegisterConfirm");
}

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

function FazerLogin() {

    if (!emailRegex.test(InputEmail.value)) {
        alert("Email inválido");
        console.log("Email inválido");
        return;
    }

    var info = {
        'email': InputEmail.value,
        'senha': InputPassword.value,
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
                    alert(data.mensagem);
                }

            })
            .fail(function (jqXHR, textStatus, data) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(data);
                alert(jqXHR['responseText']);
            });
}

function CriarLogin() {

    var info = {
        'email': RegisterEmail.value,
        'senha': RegisterPassword.value,
        'nome': RegisterName.value,
        'telef': RegisterTel.value,
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
                    alert(data.mensagem);
                }

            })
            .fail(function (jqXHR, textStatus, data) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(data);
                alert(jqXHR['responseText']);
            });
}

function capitalizeWords(inputString) {
    return inputString.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}
