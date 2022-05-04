<?php

namespace Magazord\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pessoa")
 */
class Pessoa
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;
     /**
     * @ORM\Column(type="string")
     */
    private string $nome;
     /**
     * @ORM\Column(type="string")
     */
    private string $cpf;

    public function getId(): int
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
