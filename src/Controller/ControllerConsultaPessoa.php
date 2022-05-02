<?php

namespace Magazord\Controller;

use Magazord\Infraestrutura\Persistencia\CriadorConexao;
use Magazord\Dominio\Repositorio\PdoRepositorioPessoa;

class ControllerConsultaPessoa implements InterfaceControllerRequisicao
{

    public function processaRequisicao(): void
    {
        $titulo = 'Pessoas';

        $oRepPessoa = new PdoRepositorioPessoa(CriadorConexao::criarConexao());
        $aPessoas = $oRepPessoa->buscaPessoas();

        require __DIR__ . '/../../view/pessoa/ViewConsultaPessoa.php';
    }
}
