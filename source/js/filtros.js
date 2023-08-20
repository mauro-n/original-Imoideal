var listanuncios;
var btnspage;

var page = [];
var pages = [];

var anuncios = [];

var FiltOrd;
var FiltQuat;
var FiltMetrMin;
var FiltMetrMax;
var FiltPrecMin;
var FiltPrecMax;

function MontarPages() {

    page = [];
    pages = [];

    for (var i = 0; i < anuncios.length; i++) {
        if (page.length < 5) {
            page.push(anuncios[i]);
        } else {
            pages.push(page);
            page = [];
            page.push(anuncios[i]);
        }
    }

    if (page.length > 0) {
        pages.push(page);
    }

    WritePages();
}

function WritePages(page = 0) {
    console.group("Função WritePages");

    listanuncios.innerHTML = "";
    for (var i = 0; i < pages.length; i++) {
        if (i == page) {
            for (var p = 0; p < pages[i].length; p++) {
                listanuncios.appendChild(pages[i][p]);
            }
        }
    }
    MontarBtns(page);
    document.documentElement.scrollTop = 0;

    console.log(page);
    console.groupEnd();
}

function MontarBtns(page) {
    btnspage.innerHTML = "";

    if (pages.length <= 0) {
        btnspage.innerHTML += "<li class='page-item m-1'>";
        btnspage.innerHTML += "<h5 class='text-muted'>Sem registros</h5>";
        btnspage.innerHTML += "</li>";
        return;
    }

    var afterpage = page - 1;
    var nextpage = page + 1;
    if (afterpage < 0) {
        afterpage = 0;
    }

    var arrfstpage = [];
    var firstpage;
    firstpage = page;
    for (var i = 0; i < 3; i++) {
        firstpage--;
        if (firstpage < 0) {
            firstpage = 0;
        } else {
            arrfstpage.push(firstpage);
        }
    }

    arrfstpage.sort(function (a, b) {
        return a - b;
    });

    var arrlastpg = [];
    var lastpage;
    lastpage = page;
    for (var i = 0; i < 3; i++) {
        lastpage++;
        let lt = pages.length - 1;
        if (lastpage > lt) {
            lastpage = lt;
        } else {
            arrlastpg.push(lastpage);
        }
    }

    //After
    btnspage.innerHTML += "<li class='page-item m-1'>";
    if (page == 0) {
        btnspage.innerHTML += "<button type='button' class='btn btn-outline-danger btn-sm' disabled='true'><</button>";
    } else {
        btnspage.innerHTML += "<button onclick='WritePages(" + afterpage + ");' type='button' class='btn btn-outline-danger btn-sm'><</button>";
    }
    btnspage.innerHTML += "</li>";

    //Lista 3 pagina anteriores
    for (var i = 0; i < arrfstpage.length; i++) {
        var pageexib = arrfstpage[i] + 1;
        btnspage.innerHTML += "<li class='page-item m-1'>";
        btnspage.innerHTML += "<button onclick='WritePages(" + arrfstpage[i] + ");' type='button' class='btn btn-outline-danger btn-sm'>" + pageexib + "</button>";
        btnspage.innerHTML += "</li>";
    }

    //Pagina atual
    btnspage.innerHTML += "<li class='page-item m-1'>";
    btnspage.innerHTML += "<button type='button' class='btn btn-danger btn-sm' disabled='true'>" + (page + 1) + "</button>";
    btnspage.innerHTML += "</li>";

    //Lista 3 pagina posterior
    for (var i = 0; i < arrlastpg.length; i++) {
        var pageexib = arrlastpg[i] + 1;
        btnspage.innerHTML += "<li class='page-item m-1'>";
        btnspage.innerHTML += "<button onclick='WritePages(" + arrlastpg[i] + ");' type='button' class='btn btn-outline-danger btn-sm'>" + pageexib + "</button>";
        btnspage.innerHTML += "</li>";
    }

    //Next
    btnspage.innerHTML += "<li class='page-item m-1'>";
    if (nextpage == pages.length) {
        btnspage.innerHTML += "<button onclick='WritePages(" + nextpage + ");' type='button' class='btn btn-outline-danger btn-sm'  disabled='true'>></button>";
    } else {
        btnspage.innerHTML += "<button onclick='WritePages(" + nextpage + ");' type='button' class='btn btn-outline-danger btn-sm'>></button>";
    }
    btnspage.innerHTML += "</li>";

}


function Filtrar() {

    FiltrarOrdem(FiltOrd.value);
    FiltrarQuart(FiltQuat.value);
    FiltrarRangeMetro(FiltMetrMin.value, FiltMetrMax.value);
    FiltrarRangePrice(FiltPrecMin.value, FiltPrecMax.value);

    MontarPages();
}

function FiltrarOrdem(ord) {

    let anunciosArray = Array.from(anuncios);
    anuncios = [];

    switch (ord) {

        case "0"://Relevancia
            anunciosArray.sort(function (a, b) {
                let notaA = parseFloat(a.getAttribute("ponto"));
                let notaB = parseFloat(b.getAttribute("ponto"));
                return notaB - notaA;
            });
            break;

        case "1"://Data
            anunciosArray.sort(function (a, b) {
                let dateA = new Date(a.getAttribute("data").replace(/-/g, '/')).getTime();
                let dateB = new Date(b.getAttribute("data").replace(/-/g, '/')).getTime();
                return dateB - dateA;
            });
            break;

        case "2"://Mais barato
            anunciosArray.sort(function (a, b) {
                let priceA = parseFloat(a.getAttribute("price"));
                let priceB = parseFloat(b.getAttribute("price"));
                return priceA - priceB;
            });
            break;

        case "3"://Mais caro
            anunciosArray.sort(function (a, b) {
                let priceA = parseFloat(a.getAttribute("price"));
                let priceB = parseFloat(b.getAttribute("price"));
                return priceB - priceA;
            });
            break;
    }

    anuncios = anunciosArray;
}

function FiltrarQuart(qut) {

}

function FiltrarRangeMetro(min, max) {

}

function FiltrarRangePrice(min, max) {

}

$(document).ready(function () {
    console.group("JS dos Filtros");

    listanuncios = document.getElementById("list-anuncios");
    btnspage = document.getElementById("list-btns-page");

    anuncios = listanuncios.getElementsByClassName("anunc");

    FiltOrd = document.getElementById("FiltOrd");
    FiltQuat = document.getElementById("FiltQuat");
    FiltMetrMin = document.getElementById("FiltMetrMin");
    FiltMetrMax = document.getElementById("FiltMetrMax");
    FiltPrecMin = document.getElementById("FiltPrecMin");
    FiltPrecMax = document.getElementById("FiltPrecMax");

    console.log("Iniciado com sucesso")
    console.groupEnd();

    MontarPages();
});