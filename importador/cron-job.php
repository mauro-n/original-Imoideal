<?php

//Caminho da Pasta
$directory = 'arquivos';

// Listar arquivos da pasta
$files = scandir($directory);

// Remover . e .. do array (entradas padrão do diretório)
$files = array_diff($files, array('.', '..'));

// Iterar sobre os arquivos e imprimir seus nomes
foreach ($files as $file) {
    echo $file . "<br>";
}
