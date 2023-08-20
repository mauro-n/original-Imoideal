var fileInput;
var listimgs;
var imagens = [];

$(document).ready(function () {
    fileInput = document.getElementById("fileInput");
    listimgs = document.getElementById("list-imgs");
});

function ImportImg() {
    fileInput.click();
}
function OnchangeFile(obj) {

    const formData = new FormData();

    for (const file of obj.files) {
        if (file.type.startsWith('image/')) {
            formData.append('image[]', file);
        } else {
            ExibirMsg("E", "Não foi possivel adicionar, o arquivo <b>" + file.name + "</b> não é uma imagem");
        }
    }

    if (formData.getAll('image[]').length === 0) {
        console.log('Nenhuma imagem válida selecionada.');
        return;
    }

    let loading = "<div class='d-flex justify-content-center'>";
    loading += "<span class='spinner-border text-danger me-2' style='width: 25px; height: 25px;' aria-hidden='true'></span>";
    loading += "<span class='text-danger' role='status'>Carregando imagens...</span>";
    loading += "</div>";
    listimgs.innerHTML = loading;

    console.group("Upload da imagem");
    fetch('source/sys/forms/uploadimg.php', {
        method: 'POST',
        body: formData
    })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                for (var d = 0; d < data.length; d++) {
                    if (data[d].stts) {
                        imagens.push(data[d].img);
                    }
                }
                WriteImgs();
            })
            .catch(error => {
                ExibirMsg("E", 'Erro:' + error);
                console.error('Erro:', error);
            });
    console.groupEnd();
    fileInput.value = "";
}

function RemoveImg(i) {

    console.group("Exclusão da imagem");

    var data = {
        "img": imagens[i]
    };

    console.log(data);

    fetch('source/sys/forms/deleteimg', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status) {
                    imagens.splice(i, 1);
                    WriteImgs();
                }
            })
            .catch(error => {
                ExibirMsg("E", 'Erro:' + error);
                console.error('Erro:', error);
            });
    console.groupEnd();
}
function WriteImgs() {
    //console.log(imagens);
    listimgs.innerHTML = "";
    let html = "";

    if (imagens.length > 0) {

        for (var i = 0; i < imagens.length; i++) {
            let arrimg = imagens[i].split("/");
            let nameimg = "";
            for (var n = 0; n < arrimg.length; n++) {
                nameimg = arrimg[n];
            }
            html += "<div class='img-aded mb-1' style='background-image: url(" + imagens[i] + ");'>";
            html += "<p>" + nameimg + "</p>";
            html += "<button onclick='RemoveImg(" + i + ");' type='button' class='close-btn'>&times;</button>";
            html += "</div>";
        }

    } else {
        html += "<p class='p m-0 w-100 text-center' style='font-size: 0.9em;'><small class='text-muted'>Sem imagens</small></p>";
    }
    listimgs.innerHTML = html;
}