<?php

namespace Magazord\Dominio\Repositorio;

use PDO;

class PdoRepositorio
{

    protected PDO $conexao;
    protected string $tabela;

    public function __construct(PDO $conexao, string $tabela)
    {
        $this->setConexao($conexao);
        $this->setTabela($tabela);
    }

    protected function getConexao(): PDO
    {
        return $this->conexao;
    }

    protected function getTabela(): string
    {
        return $this->tabela;
    }

    protected function setConexao(PDO $conexao): void
    {
        $this->conexao = $conexao;
    }

    protected function setTabela(string $tabela): void
    {
        $this->tabela = $tabela;
    }
}
