<?php

namespace Magazord\Dominio\Model;

class ModelContato
{

    private ?int $id;
    private bool $tipo;
    private string $descricao;
    private ModelPessoa $Pessoa;

    public function __construct(?int $id, bool $tipo, string $descricao, ModelPessoa $Pessoa)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->descricao = $descricao;
        $this->Pessoa = $Pessoa;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): bool
    {
        return $this->tipo;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getPessoa(): ModelPessoa
    {
        return $this->Pessoa;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTipo(bool $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function setPessoa(ModelPessoa $Pessoa): void
    {
        $this->Pessoa = $Pessoa;
    }
}
