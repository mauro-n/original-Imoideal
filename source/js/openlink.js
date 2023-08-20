var htmldata = "";

htmldata += "<div class='modal fade' style='cursor: wait;' data-backdrop='static' id='ModalLoading' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
htmldata += "<div class='modal-dialog modal-dialog-centered' role='document'>";
htmldata += "<div class='modal-content' style='border: 0px;background: rgba(0,0,0,0.0);'>";
htmldata += "<div class='text-center'>";
htmldata += "<div class='spinner-border text-light' style='width: 4rem; height: 4rem;' role='status'>";
htmldata += "<span class='sr-only'></span>";
htmldata += "</div>";
htmldata += "</div>";
htmldata += "</div>";
htmldata += "</div>";
htmldata += "</div>";

const htmlmodalloading = htmldata;

function AbrirLink(link) {
    $('#ModalLoading').modal('show');
//    console.log("Redirecionando para: " + window.location.href);
    window.location.href = link;
}

$(document).ready(function () {
    try {
        document.body.innerHTML += htmlmodalloading;
        console.log("Carregou - Script de Loading.");
    } catch (e) {
        console.log("ERRO - Script de Loading.")
    }
});