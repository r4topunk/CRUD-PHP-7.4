<?php

namespace Magazord\Controller;

use Magazord\Infraestrutura\Persistencia\CriadorConexao;
use Magazord\Dominio\Repositorio\PdoRepositorioContato;

class ControllerConsultaContato implements InterfaceControllerRequisicao
{

    public function processaRequisicao(): void
    {
        $titulo = 'Contato';
        $oRepContato = new PdoRepositorioContato(CriadorConexao::criarConexao());
        $aContatos = $oRepContato->buscaContatos();
        include __DIR__ . '/../../view/contato/ViewConsultaContato.php';
    }

}