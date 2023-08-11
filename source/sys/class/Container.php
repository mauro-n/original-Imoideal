<?php

class Container {

    private $logado;
    private $path;

    public function __construct($path = "") {
        $this->path = $path;
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['USER'])) {
            $this->logado = false;
        } else {
            $this->logado = true;
        }
    }

    public function WriteMenu() {

        $html = "";

        $html = $html . "<div class='container'>";
        $html = $html . "<nav class='navbar navbar-expand-lg bg-body-tertiary'>";
        $html = $html . "<div class='container-fluid'>";
        $html = $html . "<a class='navbar-brand' href='" . $this->path . ".'><img src='" . $this->path . "source/img/website/logo.png' height='40' alt='Imoideal'/></a>";
        $html = $html . "<button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>";
        $html = $html . "<span class='navbar-toggler-icon'></span>";
        $html = $html . "</button>";
        $html = $html . "<div class='collapse navbar-collapse' id='navbarSupportedContent'>";

        //Links Menu
        $html = $html . "<ul class='navbar-nav me-auto mb-2 mb-lg-0'>";
//        $html = $html . "<li class='nav-item'>";
//        $html = $html . "<a class='nav-link' aria-current='page' href='#'>Planos</a>";
//        $html = $html . "</li>";
//        $html = $html . "<li class='nav-item'>";
//        $html = $html . "<a class='nav-link' href='#'>Link</a>";
//        $html = $html . "</li>";
//        $html = $html . "<li class='nav-item dropdown'>";
//        $html = $html . "<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>";
//        $html = $html . "Dropdown";
//        $html = $html . "</a>";
//        $html = $html . "<ul class='dropdown-menu'>";
//        $html = $html . "<li><a class='dropdown-item' href='#'>Action</a></li>";
//        $html = $html . "<li><a class='dropdown-item' href='#'>Another action</a></li>";
//        $html = $html . "<li><hr class='dropdown-divider'></li>";
//        $html = $html . "<li><a class='dropdown-item' href='#'>Something else here</a></li>";
//        $html = $html . "</ul>";
//        $html = $html . "</li>";
        $html = $html . "<li class='nav-item'>";
        $html = $html . "<a class='nav-link disabled' aria-disabled='true'>Meu Condomínio</a>";
        $html = $html . "</li>";
        $html = $html . "</ul>";

        if ($this->logado) {
            $html = $html . "<div class='dropdown'>";
            $html = $html . "<a href='#' class='d-flex align-items-center text-muted text-decoration-none dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>";
            $html = $html . "<div class='img-profile rounded-circle me-2' style='background-image: url(" . $_SESSION['USER']['urlimg'] . ");'></div>";
            $html = $html . "<strong>" . $_SESSION['USER']['email'] . "</strong>";
            $html = $html . "</a>";
            $html = $html . "<ul class='dropdown-menu text-small shadow' style=''>";
            $html = $html . "<li><a class='dropdown-item' href='" . $this->path . "perfil'><i class='fa-regular fa-user text-muted me-3'></i>Perfil</a></li>";
            $html = $html . "<li><a class='dropdown-item' href='" . $this->path . "favoritos'><i style='margin-left: -3px;' class='fa-regular fa-star text-muted me-3'></i>Favoritos</a></li>";
            $html = $html . "<li><a class='dropdown-item' href='" . $this->path . "meusanuncios'><i class='fa-regular fa-file text-muted me-3'></i>Meus Anúncios</a></li>";
            $html = $html . "<li><hr class='dropdown-divider'></li>";
            $html = $html . "<li><a class='dropdown-item' href='" . $this->path . "source/sys/forms/logout'><i class='fa-solid fa-power-off text-muted me-3'></i>Sair</a></li>";
            $html = $html . "</ul>";
            $html = $html . "</div>";
        } else {
            $html = $html . "<button onclick=\"window.location = '" . $this->path . "login';\" class='btn btn-outline-danger d-flex' type='submit'>Acessar Conta</button>";
        }

        $html = $html . "</div>";
        $html = $html . "</div>";
        $html = $html . "</nav>";
        $html = $html . "</div>";
        return $html;
    }

    public function WriteRodape() {
        $html = "";

        $html = $html . "<div class='footer d-flex mt-2'>";
        $html = $html . "<div class='container'>";
        $html = $html . "<div class='d-flex flex-column flex-sm-row justify-content-between py-3 my-3'>";
        $html = $html . "<p>© 2023 Imoideal</p>";
        $html = $html . "<ul class='list-unstyled d-flex' style='font-size: 1.4em;'>";
        $html = $html . "<li class='ms-3'><a class='text-white' href='#' target='_blank'><img src='" . $this->path . "source/img/googleplay.png' height='30' alt='Google Play'/></a></li>";
        $html = $html . "<li class='ms-3'><a class='text-white' href='#' target='_blank'><img src='" . $this->path . "source/img/applestore.png' height='30' alt='App Store'/></a></li>";
        $html = $html . "</ul>";
        $html = $html . "</div>";
        $html = $html . "</div>";
        $html = $html . "</div>";

        return $html;
    }

    public function WriteSEO($titulo, $descricao, $tags = "") {
        $html = "";

        $html = $html . "<title>" . $titulo . "</title>";
        $html = $html . "<meta name='title' content='" . $titulo . "'>";
        $html = $html . "<meta name='description' content='" . $descricao . "'>";
        $html = $html . "<meta name='keywords' content='aluguel, compra, terreno, casa, apartamento, quarto, terrenos, casas, apartamentos, quartos, imodeal, " . $descricao . "'>";
        $html = $html . "<meta name='robots' content='index, follow'>";
        $html = $html . "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
        $html = $html . "<meta name='language' content='Portuguese'>";
        $html = $html . "<meta name='author' content='Imodeal.com'>";

        return $html;
    }

}

?>
