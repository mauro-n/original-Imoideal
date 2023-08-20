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

        $html .= "<div class='container'>";
        $html .= "<nav class='navbar navbar-expand-lg bg-body-tertiary'>";
        $html .= "<div class='container-fluid'>";
        $html .= "<h1 class='hidden-h1'>Imoideal</h1>";
        $html .= "<a class='navbar-brand' onclick=\"AbrirLink('" . $this->path . ".');\"><img src='" . $this->path . "source/img/website/logo.png' height='40' alt='Imoideal'/></a>";
        $html .= "<button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>";
        $html .= "<span class='navbar-toggler-icon'></span>";
        $html .= "</button>";
        $html .= "<div class='collapse navbar-collapse' id='navbarSupportedContent'>";

        //Links Menu
        $html .= "<ul class='navbar-nav me-auto mb-2 mb-lg-0'>";
        $html .= "<li class='nav-item'>";
        $html .= "<a class='nav-link disabled' aria-disabled='true'>Meu Condomínio</a>";
        $html .= "</li>";
        $html .= "</ul>";

        if ($this->logado) {
            $html .= "<div class='dropdown'>";
            $html .= "<a href='#' class='d-flex align-items-center text-muted text-decoration-none dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>";
            $html .= "<div class='img-profile rounded-circle me-2' style='background-image: url(" . $_SESSION['USER']['urlimg'] . ");'></div>";
            $html .= "<strong>" . $_SESSION['USER']['email'] . "</strong>";
            $html .= "</a>";
            $html .= "<ul class='dropdown-menu text-small shadow' style=''>";
            $html .= "<li><a class='dropdown-item' onclick=\"AbrirLink('" . $this->path . "perfil');\"><i id='icon-perfil' class='fa-regular fa-user me-3'></i>Perfil</a></li>";
            $html .= "<li><a class='dropdown-item' onclick=\"AbrirLink('" . $this->path . "favoritos');\"><i id='icon-favorite' style='margin-left: -3px;' class='fa-regular fa-star me-3'></i>Favoritos</a></li>";
            $html .= "<li><a class='dropdown-item' onclick=\"AbrirLink('" . $this->path . "meusanuncios');\"><i id='icon-myanunc' class='fa-regular fa-file me-3'></i>Meus Anúncios</a></li>";
            $html .= "<li><hr class='dropdown-divider'></li>";
            $html .= "<li><a class='dropdown-item' onclick=\"AbrirLink('" . $this->path . "source/sys/forms/logout');\"><i id='icon-logout' class='fa-solid fa-power-off me-3'></i>Sair</a></li>";
            $html .= "</ul>";
            $html .= "</div>";
        } else {
            $html .= "<button onclick=\"AbrirLink('" . $this->path . "login');\" class='btn btn-outline-danger d-flex' type='submit'>Acessar Conta</button>";
        }

        $html .= "</div>";
        $html .= "</div>";
        $html .= "</nav>";
        $html .= "</div>";
        return $html;
    }

    public function WriteRodape() {
        $html = "";

        $html .= "<footer class='footer bg-dark py-4 text-white'>";
        $html .= "<div class='container'>";
        $html .= "<div class='row justify-content-between align-items-center'>";
        $html .= "<div class='col-md-6 text-center text-md-start'>";
        $html .= "<p class='mb-0'>&copy; " . date('Y') . " Imoideal</p>";
        $html .= "</div>";
        $html .= "<div class='col-md-6 text-center text-md-end'>";
        $html .= "<ul class='list-unstyled social-icons d-flex justify-content-center justify-content-md-end mb-0'>";
        $html .= "<li class='ms-3'><a href='#' style='color: white;'><i class='fab fa-google-play'></i></a></li>";
        $html .= "<li class='ms-3'><a href='#' style='color: white;'><i class='fab fa-apple'></i></a></li>";
        $html .= "</ul>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</footer>";

        return $html;
    }

    public function WriteSEO($titulo, $descricao, $tags = "") {
        $html = "";

        $html .= "<title>" . $titulo . "</title>";
        $html .= "<meta name='title' content='" . $titulo . "'>";
        $html .= "<meta name='description' content='" . $descricao . "'>";
        $html .= "<meta name='keywords' content='aluguel, compra, terreno, casa, apartamento, quarto, terrenos, casas, apartamentos, quartos, imodeal, " . $descricao . "'>";
        $html .= "<meta name='robots' content='index, follow'>";
        $html .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
        $html .= "<meta name='language' content='Portuguese'>";
        $html .= "<meta name='author' content='Imodeal.com'>";

        return $html;
    }

}

?>
