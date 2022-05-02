<?php

namespace Magazord\Dominio\Model;

class ModelPessoa
{

    private ?int $id;
    private string $nome;
    private string $cpf;

    public function __construct(?int $id, string $nome, string $cpf)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }
}
