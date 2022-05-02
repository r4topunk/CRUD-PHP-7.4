<?php

namespace Magazord\Controller;

use Magazord\Dominio\Model\ModelPessoa;
use Magazord\Infraestrutura\Persistencia\CriadorConexao;
use Magazord\Dominio\Repositorio\PdoRepositorioPessoa;
use PDO;

class ControllerManutencaoPessoa implements InterfaceControllerRequisicao
{

    private PdoRepositorioPessoa $Persistencia;

    public function __construct()
    {
        $this->Persistencia = new PdoRepositorioPessoa(CriadorConexao::criarConexao());
    }

    private function getPersistencia() {
        return $this->Persistencia;
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
            $oRepPessoa = new PdoRepositorioPessoa(CriadorConexao::criarConexao());
            $xPessoa = $oRepPessoa->getPessoaById($xIdParam);
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
        if (in_array($_GET['acao'], ['incluir', 'alterar'])) {
            if (empty($_POST['nome']) || empty($_POST['cpf'])) {
                header('Location: /consulta-pessoas');
            }

            $xId = empty($_POST['id']) ? null : (int) $_POST['id'];
    
            $oPessoa = new ModelPessoa(
                $xId,
                filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS),
                filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS)
            );
            $this->getPersistencia()->salvar($oPessoa);
        } else if ($_GET['acao'] === 'deletar') {
            $oPessoa = new ModelPessoa(
                intVal($_POST['id']),
                '',
                ''
            );
            $this->getPersistencia()->deletePessoa($oPessoa);
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
}
