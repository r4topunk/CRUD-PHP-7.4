<?php

namespace Magazord\Controller;

use Magazord\Entity\Contato;
use Magazord\Entity\Pessoa;
use Magazord\Helper\EntityManagerFactory;

class ControllerManutencaoContato implements InterfaceControllerRequisicao
{

    private $entityManager;

    public function __construct()
    {
        $oEntityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $oEntityManagerFactory->getEntityManager();
    }

    public function processaRequisicao(): void
    {
        switch ($_GET['processo']) {
            case 'exibicao':
                $this->processaExibicao();
                break;
            case 'manutencao':
                $this->processaDados();
                break;
            default:
                header('Location: /consulta-contatos');
                break;
        }
    }

    private function processaExibicao(): void
    {
        $titulo = 'Manutenção de Contato';

        $xId = $xTipo = $xDescricao = '';
        $aPessoas = [];
        
        $xIdParam = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if ($xIdParam) {
            $oRepositorio = $this->entityManager->getRepository(Contato::class);
            $oContato = $oRepositorio->find($xIdParam);
            if ($oContato) {
                $xId = $oContato->getId();
                $xTipo = (bool) $oContato->getTipo();
                $xDescricao = $oContato->getDescricao();
                $aPessoas[] = $oContato->getPessoa();
            }
        }

        list($bIsInclusao, $bReadOnly) = $this->getControlesAcao();

        if (!$bReadOnly) {
            $oRepositorio = $this->entityManager->getRepository(Pessoa::class);
            $aPessoas = $oRepositorio->findAll();
        }

        require __DIR__ . '/../../view/contato/ViewManutencaoContato.php';
    }

    private function processaDados(): void
    {
        switch ($_GET['acao']) {
            case 'incluir':
                $this->validaParametros(['descricao', 'idPessoa']);

                $oContato = new Contato();
                $oContato->setTipo(!empty(filter_input(INPUT_POST, 'tipo')));
                $oContato->setDescricao(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS));

                $oRepositorioPessoa = $this->entityManager->getRepository(Pessoa::class);
                $oPessoa = $oRepositorioPessoa->find(filter_input(INPUT_POST, 'idPessoa', FILTER_VALIDATE_INT));

                $oContato->setPessoa($oPessoa);

                $this->entityManager->persist($oContato);
                $this->entityManager->flush();
                break;
            
            case 'alterar':
                $this->validaParametros('id', 'descricao', 'idPessoa');
                $oRepositorio = $this->entityManager->getRepository(Contato::class);

                $iId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                $oContato = $oRepositorio->find(intval($_POST['id']));
                $oContato->setTipo(!empty(filter_input(INPUT_POST, 'tipo')));
                $oContato->setDescricao(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS));

                $oRepositorioPessoa = $this->entityManager->getRepository(Pessoa::class);
                $oPessoa = $oRepositorioPessoa->find(filter_input(INPUT_POST, 'idPessoa', FILTER_VALIDATE_INT));

                $oContato->setPessoa($oPessoa);

                $this->entityManager->flush();
                break;
            case 'deletar':
                $iId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                if (!$iId) {
                    header('Location: /consulta-contatos');
                }

                $oContato = $this->entityManager->getReference(Contato::class, $iId);
                $oContato->setPessoa(new Pessoa());

                $this->entityManager->remove($oContato);
                $this->entityManager->flush();
                break;
            default:
                header('Location: /consulta-contatos');
                break;
        }

        header('Location: /consulta-contatos');
    }

    private function getControlesAcao(): array
    {
        $bIsInclusao = false;
        $bReadOnly = false;
        switch (filter_input(INPUT_GET, 'acao')) {
            case 'incluir':
                $bIsInclusao = true;
            case 'alterar':
                $bReadOnly = false;
                break;
            case 'visualizar':
                $bReadOnly = true;
                break;
            default:
                echo "Ação não reconhecida";
                exit(0);
        }
        return [
            $bIsInclusao,
            $bReadOnly
        ];
    }

    private function validaParametros($aValores): void
    {
        foreach ($aValores as $sValor) {
            if (empty($_POST[$sValor])) {
                header('Location: /consulta-contatos');
            }   
        }
    }
}
