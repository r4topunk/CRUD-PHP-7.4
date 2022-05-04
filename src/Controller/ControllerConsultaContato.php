<?php

namespace Magazord\Controller;

use Magazord\Entity\Contato;
use Magazord\Helper\EntityManagerFactory;

require_once __DIR__ . '/../../vendor/autoload.php';

class ControllerConsultaContato implements InterfaceControllerRequisicao
{

    private $repository;

    public function __construct()
    {
        $oEntityManagerFactory = new EntityManagerFactory();
        $oEntityManager = $oEntityManagerFactory->getEntityManager();
        $this->repository = $oEntityManager->getRepository(Contato::class);
    }

    public function processaRequisicao(): void
    {
        $titulo = 'Contato';
        $aContatos = $this->repository->findAll();
        include __DIR__ . '/../../view/contato/ViewConsultaContato.php';
    }

}