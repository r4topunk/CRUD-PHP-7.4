<?php

namespace Magazord\Controller;

use Magazord\Entity\Pessoa;
use Magazord\Helper\EntityManagerFactory;

class ControllerManutencaoPessoa implements InterfaceControllerRequisicao
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
                header('Location: /consulta-pessoas');
                break;
        }
    }

    public function processaExibicao(): void
    {
        $titulo = 'Manutenção de Pessoa';

        $xIdParam = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $xId = $xNome = $xCpf = '';

        if ($xIdParam) {
            $oRepositorio = $this->entityManager->getRepository(Pessoa::class);
            $xPessoa = $oRepositorio->find($xIdParam);
            if ($xPessoa) {
                $xId = $xPessoa->getId();
                $xNome = $xPessoa->getNome();
                $xCpf = $xPessoa->getCpf();
            }
        }

        list($bIsInclusao, $bReadOnly) = $this->getControlesAcao();
        require __DIR__ . '/../../view/pessoa/ViewManutencaoPessoa.php';
    }

    private function processaDados(): void
    {
        switch ($_GET['acao']) {
            case 'incluir':
                $this->validaParametros(['nome', 'cpf']);
                $oPessoa = new Pessoa();
                $oPessoa->setNome(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
                $oPessoa->setCpf(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS));
                
                $this->entityManager->persist($oPessoa);
                $this->entityManager->flush();
                break;
            
            case 'alterar':
                $this->validaParametros('id', 'nome', 'cpf');
                $oRepositorio = $this->entityManager->getRepository(Pessoa::class);

                $iId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                $oPessoa = $oRepositorio->find(intval($_POST['id']));
                $oPessoa->setNome(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
                $oPessoa->setCpf(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS));
                $this->entityManager->flush();
                break;
            case 'deletar':
                $iId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                if (!$iId) {
                    header('Location: /consulta-pessoas');
                }

                $oPessoa = $this->entityManager->getReference(Pessoa::class, $iId);
                $this->entityManager->remove($oPessoa);
                $this->entityManager->flush();
                break;
            default:
                header('Location: /consulta-pessoas');
                break;
        }
        header('Location: /consulta-pessoas');
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
                header('Location: /consulta-pessoas');
            }   
        }
    }
}
