<?php

namespace Magazord\Controller;

use Magazord\Entity\Pessoa;
use Magazord\Helper\EntityManagerFactory;

require_once __DIR__ . '/../../vendor/autoload.php';

class ControllerConsultaPessoa implements InterfaceControllerRequisicao
{

    private $repository;

    public function __construct()
    {
        $oEntityManagerFactory = new EntityManagerFactory();
        $oEntityManager = $oEntityManagerFactory->getEntityManager();
        $this->repository = $oEntityManager->getRepository(Pessoa::class);
    }

    public function processaRequisicao(): void
    {
        $titulo = 'Pessoas';
        $aPessoas = $this->repository->findAll();
        require __DIR__ . '/../../view/pessoa/ViewConsultaPessoa.php';
    }
}
