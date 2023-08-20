<?php

//Limpar Pasta Temp
$path = "../../../files/temp/uploads/" . $_SESSION['USER']['userid'];
$arquivos = scandir($path);
foreach ($arquivos as $arquivo) {
    if ($arquivo != "." && $arquivo != "..") {
        unlink($path . "/" . $arquivo);
    }
}
rmdir($path);
