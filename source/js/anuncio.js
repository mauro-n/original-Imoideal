function AddFav(cod) {
    console.group("Adicionando favorito");

    var botao = document.getElementById("btnfav");

    var info = {
        'save': 1,
        'postid': cod,
    };
    
    console.log(cod);
    console.log(info);

    botao.onclick = function () {};
    botao.innerHTML = "<span class='spinner-border spinner-border-sm' aria-hidden='true'></span>";

    var ajax1 = $.ajax({
        url: "../source/sys/forms/favoritar-post.php",
        type: 'POST',
        data: info,
        dataType: 'json',
        async: true,
    })
            .done(function (data) {
                console.log(data);
                if (data.status) {
                    botao.onclick = function () {
                        RemoveFav(cod);
                    };
                    botao.innerHTML = "<i class='fa-solid fa-xmark'></i> Remover Favoritos";
                } else {
                    botao.onclick = function () {
                        AddFav(cod);
                    };
                    botao.innerHTML = "<small><i class='fa-regular fa-bookmark me-2'></i></small>Salvar";
                }

            })
            .fail(function (jqXHR, textStatus, data) {
                ExibirMsg("E", jqXHR['responseText']);
                botao.onclick = function () {
                    AddFav(cod);
                };
                botao.innerHTML = "<small><i class='fa-regular fa-bookmark me-2'></i></small>Salvar";
            });
            
    console.groupEnd();
}

function RemoveFav(cod) {
    console.group("Removendo favorito");

    var botao = document.getElementById("btnfav");

    var info = {
        'save': 0,
        'postid': cod,
    };

    console.log(cod);
    console.log(info);

    botao.onclick = function () {};
    botao.innerHTML = "<span class='spinner-border spinner-border-sm' aria-hidden='true'></span>";

    var ajax1 = $.ajax({
        url: "../source/sys/forms/favoritar-post.php",
        type: 'POST',
        data: info,
        dataType: 'json',
        async: true,
    })
            .done(function (data) {
                console.log(data);
                if (data.status) {
                    botao.onclick = function () {
                        AddFav(cod);
                    };
                    botao.innerHTML = "<small><i class='fa-regular fa-bookmark me-2'></i></small>Salvar";

                } else {
                    botao.onclick = function () {
                        RemoveFav(cod);
                    };
                    botao.innerHTML = "<i class='fa-solid fa-xmark'></i> Remover Favoritos";
                }
            })
            .fail(function (jqXHR, textStatus, data) {
                ExibirMsg("E", jqXHR['responseText']);
                botao.onclick = function () {
                    RemoveFav(cod);
                };
                botao.innerHTML = "<i class='fa-solid fa-xmark'></i> Remover Favoritos";
            });

    console.groupEnd();
}