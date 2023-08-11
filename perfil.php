<?php
require_once './source/sys/class/Session.php';
require_once './source/sys/class/Container.php';

$session = new Session();
$session->ValidSession();
$session->RefreshSession();

$html = new Container();
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Perfil - ImoIdeal</title>
        <meta name='title' content='Perfil - ImoIdeal'>
        <meta name='keywords' content='aluguel, compra, terreno, casa, apartamento, quarto, terrenos, casas, apartamentos, quartos, imodeal'>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta name="robots" content="noindex, nofollow">
        <meta name="robots" content="no-index, no-follow">
        <meta name='language' content='Portuguese'>
        <meta name='author' content='Imodeal.com'>

        <link rel="apple-touch-icon" sizes="57x57" href="source/img/favicon/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="source/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="source/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="source/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="source/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="source/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="source/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="source/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="source/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="source/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="source/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="source/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="source/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="source/img/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="source/img/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="source/css/perfil.css">
        <link rel="stylesheet" type="text/css" href="source/css/rodape.css">

    </head>
    <body>
        <?php
        echo $html->WriteMenu();
        ?>

        <hr class="divisa">

        <div class="container" style="min-height: 500px;">
            <div class="row mt-4">
                <div class="col-md-3 mb-4">
                    <div class="img-prof" style="background-image: url(<?php echo $_SESSION['USER']['urlimg'];?>);"></div>
                    <div class="col edit-anunc"><i class="fa-regular fa-pen-to-square"></i></div>
                    <div class="col del-anunc"><i class="fa-regular fa-trash-can"></i></div>
                </div>
                <div class="col-md mb-4">
                    <div class="card w-100 h-100">
                        <div class="position-relative">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#editarPerfilModal" class="btn btn-custom position-absolute top-0 end-0"><i class="fas fa-edit text-muted me-2"></i></button>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title mb-3"><?php echo $_SESSION['USER']['nome'];?></h4>
                            <p class="card-text"><i class="fa-regular fa-envelope text-muted me-2"></i><b class="text-muted me-1">Email:</b><?php echo $_SESSION['USER']['email'];?><small style="opacity: 0.8;"><i class="fa-solid fa-circle-check text-success ms-1"></i></small></p>
                            <p class="card-text"><i class="fa-brands fa-whatsapp text-muted me-2"></i><b class="text-muted me-1">WhatsApp:</b><?php echo $_SESSION['USER']['telefone'];?></p>
                            <hr class="mt-4 mb-4">
                            <h5 class="card-title mb-3"><i class="fa-regular fa-credit-card text-muted me-2"></i><b class="text-muted me-1">Plano:</b><span class="badge text-bg-secondary">Grátis</span></h5>
                            <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-dollar-sign me-2"></i>Alterar Plano</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        echo $html->WriteRodape();
        ?>

        <!-- Modal para editar perfil -->
        <div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarPerfilModalLabel">Editar Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário para editar perfil (adapte de acordo com suas necessidades) -->
                        <form>
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" value="Nome do Usuário">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="usuario@exemplo.com">
                            </div>
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" value="(99) 99999-9999">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-outline-danger">Salvar Alterações</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>