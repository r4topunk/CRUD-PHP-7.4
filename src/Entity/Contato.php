<?php

namespace Magazord\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity
 * @ORM\Table(name="contato")
 */
class Contato
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $tipo;
    /**
     * @ORM\Column(type="string")
     */
    private string $descricao;
    
    /**
     * @ManyToOne(targetEntity="Pessoa", cascade={"remove"})
     * @JoinColumn(name="pessoaId", referencedColumnName="id", onDelete="CASCADE")
     */
    private Pessoa $Pessoa;

    public function getId(): int
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

    public function getPessoa(): Pessoa
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

    public function setPessoa(Pessoa $Pessoa): void
    {
        $this->Pessoa = $Pessoa;
    }
}
