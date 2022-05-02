<?php

namespace Magazord\Dominio\Repositorio;

use Magazord\Dominio\Model\ModelContato;
use Magazord\Dominio\Model\ModelPessoa;
use PDO;
use PDOException;

class PdoRepositorioContato  extends PdoRepositorio
{

    public function __construct(PDO $conexao)
    {
        parent::__construct($conexao, 'contato');
    }

    public function buscaContatos(): array
    {
        $sqlConsulta = 'SELECT * FROM contato JOIN pessoa ON pessoa.idPessoa = contato.idPessoa;';
        $query = $this->getConexao()->query($sqlConsulta);

        return $this->hidrataListaContatos($query);
    }

    public function salvar(ModelContato $contato): bool
    {
        if ($contato->getId() === null) {
            return $this->insertContato($contato);
        }

        return $this->updateContato($contato);
    }

    public function insertContato(ModelContato $contato): bool
    {
        $sqlInsert = 'INSERT INTO contato (tipo, descricao, idPessoa) VALUES (:tipo, :descricao, :idPessoa);';
        $query = $this->getConexao()->prepare($sqlInsert);
        $query->bindValue(':tipo', $contato->getTipo(), PDO::PARAM_BOOL);
        $query->bindValue(':descricao', $contato->getDescricao(), PDO::PARAM_STR);
        $query->bindValue(':idPessoa', $contato->getPessoa()->getId(), PDO::PARAM_INT);
        $result = $query->execute();

        if ($result) {
            $contato->setId($this->getConexao()->lastInsertId());
        }

        return $result;
    }

    public function getContato(ModelContato $contato): array
    {
        $sqlConsulta = 'SELECT * FROM contato WHERE idContato = :id;';
        $query = $this->getConexao()->prepare($sqlConsulta);
        $query->bindValue(':id', $contato->getId(), PDO::PARAM_INT);

        return $this->hidrataListaContatos($query);
    }

    public function getContatoById(int $iId)
    {
        $sqlConsulta = 'SELECT * FROM contato JOIN pessoa ON pessoa.idPessoa = contato.idPessoa WHERE idContato = :id;';
        $query = $this->getConexao()->prepare($sqlConsulta);
        $query->bindValue(':id', $iId, PDO::PARAM_INT);
        $query->execute();
        $aDadosContato = $query->fetch(PDO::FETCH_ASSOC);
        // var_dump($aDadosContato);
        if ($aDadosContato) {
            return new ModelContato(
                $aDadosContato['idContato'],
                $aDadosContato['tipo'],
                $aDadosContato['descricao'],
                new ModelPessoa($aDadosContato['idPessoa'], $aDadosContato['nome'], $aDadosContato['cpf'])
            );
        } else {
            return null;
        }

        return $this->hidrataListaContatos($query);
    }

    public function updateContato(ModelContato $contato): bool
    {
        $sqlUpdate = 'UPDATE contato SET tipo = :tipo, descricao = :descricao WHERE idContato = :id;';
        $query = $this->getConexao()->prepare($sqlUpdate);
        $query->bindValue(':tipo', $contato->getTipo(), PDO::PARAM_BOOL);
        $query->bindValue(':descricao', $contato->getDescricao(), PDO::PARAM_STR);
        $query->bindValue(':id', $contato->getId(), PDO::PARAM_INT);

        return $query->execute();
    }

    public function deleteContato(ModelContato $contato): bool
    {
        $sqlDelete = 'DELETE FROM contato WHERE idContato = :id;';
        $query = $this->getConexao()->prepare($sqlDelete);
        $query->bindValue(':id', $contato->getId(), PDO::PARAM_INT);

        return $query->execute();
    }

    public function hidrataListaContatos(\PDOStatement $query): array
    {
        $aListaDadosContatos = $query->fetchAll(PDO::FETCH_ASSOC);
        $aListaContatos = [];
        $aListaPessoas = [];

        foreach ($aListaDadosContatos as $aDados) {
            if (!in_array($aDados['idPessoa'], $aListaPessoas)) {
                $aListaPessoas[$aDados['idPessoa']] = new ModelPessoa(
                    $aDados['idPessoa'],
                    $aDados['nome'],
                    $aDados['cpf']
                );
            }

            $aListaContatos[] = new ModelContato(
                $aDados['idContato'],
                $aDados['tipo'],
                $aDados['descricao'],
                $aListaPessoas[$aDados['idPessoa']]
            );
        }

        return $aListaContatos;
    }
}
