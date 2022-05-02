<?php

namespace Magazord\Controller;

class ControllerConsultaInicio implements InterfaceControllerRequisicao
{

    public function processaRequisicao(): void
    {
        $titulo = 'Magazord';
        include __DIR__ . '/../../view/inicio.php';
    }

}