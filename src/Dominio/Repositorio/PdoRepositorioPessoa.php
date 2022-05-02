<?php

namespace Magazord\Dominio\Repositorio;

use Magazord\Dominio\Model\ModelPessoa;
use PDO;

class PdoRepositorioPessoa extends PdoRepositorio
{

    public function __construct(PDO $conexao)
    {
        parent::__construct($conexao, 'pessoa');
    }

    public function buscaPessoas(): array
    {
        $sqlConsulta = 'SELECT * FROM pessoa';
        $query = $this->getConexao()->query($sqlConsulta);

        return $this->hidrataListaPessoas($query);
    }

    public function salvar(ModelPessoa $pessoa): bool
    {
        if ($pessoa->getId() === null) {
            return $this->insertPessoa($pessoa);
        }

        return $this->updatePessoa($pessoa);
    }

    public function insertPessoa(ModelPessoa $pessoa): bool
    {
        $sqlInsert = 'INSERT INTO pessoa (nome, cpf) VALUES (:nome, :cpf);';
        $query = $this->getConexao()->prepare($sqlInsert);
        $query->bindValue(':nome', $pessoa->getNome(), PDO::PARAM_STR);
        $query->bindValue(':cpf', $pessoa->getCpf(), PDO::PARAM_STR);
        $result = $query->execute();

        if ($result) {
            $pessoa->setId($this->getConexao()->lastInsertId());
        }

        return $result;
    }

    public function getPessoa(ModelPessoa $pessoa): array
    {
        $sqlConsulta = 'SELECT * FROM pessoa WHERE idPessoa = :id;';
        $query = $this->getConexao()->prepare($sqlConsulta);
        $query->bindValue(':id', $pessoa->getId(), PDO::PARAM_INT);

        return $this->hidrataListaPessoas($query);
    }

    public function getPessoaById(int $iId)
    {
        $sqlConsulta = 'SELECT * FROM pessoa WHERE idPessoa = :id;';
        $query = $this->getConexao()->prepare($sqlConsulta);
        $query->bindValue(':id', $iId, PDO::PARAM_INT);
        $query->execute();
        $aDadosPessoa = $query->fetch(PDO::FETCH_ASSOC);
        if ($aDadosPessoa) {
            return new ModelPessoa($aDadosPessoa['idPessoa'], $aDadosPessoa['nome'], $aDadosPessoa['cpf']);
        } else {
            return null;
        }
    }

    public function updatePessoa(ModelPessoa $pessoa): bool
    {
        $sqlUpdate = 'UPDATE pessoa SET nome = :nome, cpf = :cpf WHERE idPessoa = :id;';
        $query = $this->getConexao()->prepare($sqlUpdate);
        $query->bindValue(':nome', $pessoa->getNome(), PDO::PARAM_STR);
        $query->bindValue(':cpf', $pessoa->getCpf(), PDO::PARAM_STR);
        $query->bindValue(':id', $pessoa->getId(), PDO::PARAM_INT);

        return $query->execute();
    }

    public function deletePessoa(ModelPessoa $pessoa): bool
    {
        $sqlDelete = 'DELETE FROM pessoa WHERE idPessoa = :id;';
        $query = $this->getConexao()->prepare($sqlDelete);
        $query->bindValue(':id', $pessoa->getId(), PDO::PARAM_INT);

        return $query->execute();
    }

    public function hidrataListaPessoas(\PDOStatement $query): array
    {
        $listaDadosPessoas = $query->fetchAll(PDO::FETCH_ASSOC);
        $listaPessoas = [];

        foreach ($listaDadosPessoas as $dadosPessoa) {
            $listaPessoas[] = new ModelPessoa(
                $dadosPessoa['idPessoa'],
                $dadosPessoa['nome'],
                $dadosPessoa['cpf']
            );
        }

        return $listaPessoas;
    }
}
