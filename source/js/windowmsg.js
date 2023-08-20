var htmlmodalerro = "<div class='modal fade' id='JanelaErroModal' data-bs-backdrop='static' data-backdrop='static' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
htmlmodalerro = htmlmodalerro + "<div class='modal-dialog modal-dialog-centered' role='document'>";
htmlmodalerro = htmlmodalerro + "<div class='modal-content'>";
htmlmodalerro = htmlmodalerro + "<div class='modal-header'>";
htmlmodalerro = htmlmodalerro + "<h5 class='modal-title' id='ModalMsgLabel'></h5>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "<div class='modal-body' id='modalerrotext'></div>";
htmlmodalerro = htmlmodalerro + "<div class='modal-footer'>";
htmlmodalerro = htmlmodalerro + "<button class='btn btn-secondary btn-sm' type='button'  data-bs-dismiss='modal' data-dismiss='modal'><i class='fa-solid fa-xmark'></i> Fechar</button>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "</div>";

function ExibirMsg(typ, msg) {
    console.group("Classe de mensagem");
    console.log(msg);
    console.groupEnd();

    switch (typ.toUpperCase()) {
        case "I":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-circle-info text-info me-2''></i>Info";
            break;
        case "W":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-triangle-exclamation text-warning me-2''></i>Aviso";
            break;
        case "E":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-triangle-exclamation text-danger me-2'></i>Erro";
            break;
        case "S":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-check text-success me-2''></i>Sucesso";
            break;
    }

    document.getElementById("modalerrotext").innerHTML = msg;

    const intmodalerro = setInterval(() => {
        if (!$('#JanelaErroModal').is(':visible')) {
            $('#JanelaErroModal').modal('show');
        } else {
            clearInterval(intmodalerro);
        }
    }, 500);
}

$(document).ready(function () {
    try {
        document.body.innerHTML += htmlmodalerro;
        console.log("Carregou - Script de Janela de Mensagens.");
    } catch (e) {
        console.log("ERRO - Script de Janela de Mensagens.")
    }
});

