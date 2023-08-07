var InputEmail;
var InputPassword;

var RegisterEmail;
var RegisterName;
var RegisterTel;
var RegisterPassword;
var RegisterConfirm;

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

    switch (obj.id) {
        case "RegisterEmail":
            obj.value = applyEmailMask(value);
//            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
//            if (!emailRegex.test(value)) {
//                console.log("Email inválido");
//            }
            break;
        case "RegisterName":
            obj.value = applyNameMask(value);
//            const nameRegex = /^[A-Za-zÀ-ÿ\s]+$/;
//            if (!nameRegex.test(value)) {
//                console.log("Nome inválido");
//            }
            break;
        case "RegisterTel":
            value = value.replace(/\D/g, '');
            if (value.length > 11) {
                value = value.substr(0, 11); // Limita o valor a 11 dígitos
            }
            const formattedValue = value.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})$/, "($1) $2 $3-$4");
            obj.value = formattedValue;
            break;
    }
}

function OnChange(obj){
    
}

function FazerLogin() {

}

function CriarLogin() {

}
