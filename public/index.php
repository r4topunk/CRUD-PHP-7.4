<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Magazord\Controller\ControllerConsultaInicio;
use Magazord\Controller\ControllerConsultaPessoa;
use Magazord\Controller\ControllerConsultaContato;

use Magazord\Controller\ControllerManutencaoContato;
use Magazord\Controller\ControllerManutencaoPessoa;


try {
    main();
} catch (\Exception $ex) {
    echo $ex->getMessage();
}

function main(): void
{
    switch ($_SERVER['PATH_INFO']) {
        case '':
        case '/':
        case '/index':
            $controlador = new ControllerConsultaInicio();
            $controlador->processaRequisicao();
            break;
        case '/consulta-pessoas':
            $controlador = new ControllerConsultaPessoa();
            $controlador->processaRequisicao();
            break;
        case '/manutencao-pessoa':
            $controlador = new ControllerManutencaoPessoa();
            $controlador->processaRequisicao();
            break;
        case '/consulta-contatos':
            $controlador = new ControllerConsultaContato();
            $controlador->processaRequisicao();
            break;
        case '/manutencao-contato':
            $controlador = new ControllerManutencaoContato();
            $controlador->processaRequisicao();
            break;
        default:
            echo "404 - Não encontrado";
            break;
    }
}