<?php

namespace Magazord\Controller;

use Magazord\Dominio\Model\ModelContato;
use Magazord\Dominio\Model\ModelPessoa;
use Magazord\Infraestrutura\Persistencia\CriadorConexao;
use Magazord\Dominio\Repositorio\PdoRepositorioContato;
use Magazord\Dominio\Repositorio\PdoRepositorioPessoa;

class ControllerManutencaoContato implements InterfaceControllerRequisicao
{

    private PdoRepositorioContato $Persistencia;

    public function __construct()
    {
        $this->Persistencia = new PdoRepositorioContato(CriadorConexao::criarConexao());
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
            $oRepContato = new PdoRepositorioContato(CriadorConexao::criarConexao());
            /* @var $xContato ModelContato */
            $xContato = $oRepContato->getContatoById($xIdParam);
            if ($xContato) {
                $xId = $xContato->getId();
                $xTipo = (bool) $xContato->getTipo();
                $xDescricao = $xContato->getDescricao();
                $aPessoas[] = $xContato->getPessoa();
            }
        }

        list($bIsInclusao, $bReadOnly) = $this->getControlesAcao();

        if ($bIsInclusao) {
            $oRepPessoa = new PdoRepositorioPessoa(CriadorConexao::criarConexao());
            $aPessoas = $oRepPessoa->buscaPessoas();
        }

        require __DIR__ . '/../../view/contato/ViewManutencaoContato.php';
    }

    private function processaDados(): void
    {
        if (in_array($_GET['acao'], ['incluir', 'alterar'])) {
            if (empty($_POST['descricao']) || empty($_POST['idPessoa'])) {
                header('Location: /consulta-contatos');
            }

            $xId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $iIdPessoa = (int) $_POST['idPessoa'];
            $oPessoa = new ModelPessoa($iIdPessoa, '', '');
    
            $oContato = new ModelContato(
                $xId,
                !empty(filter_input(INPUT_POST, 'tipo')),
                filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS),
                $oPessoa
            );
            $this->getPersistencia()->salvar($oContato);
        } else if ($_GET['acao'] === 'deletar') {
            $xId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if ($xId) {
                $oContato = new ModelContato($xId, '', '', new ModelPessoa(null, '', ''));
                $this->getPersistencia()->deleteContato($oContato);
            }
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
}
