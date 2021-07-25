<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $TypeDocumment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Path;


    /**
     * Permet d'initialiser le Description
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initilaizeDescription()
    {
        if(emoty($this->getDescription)){
            $descriptionify = new Descriptionify();
            $this->Description = $descriptionify->descriptionify($this->Nom);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getTypeDocumment(): ?string
    {
        return $this->TypeDocumment;
    }

    public function setTypeDocumment(string $TypeDocumment): self
    {
        $this->TypeDocumment = $TypeDocumment;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPath()
    {
        return $this->Path;
    }

    public function setPath($Path)
    {
        $this->Path = $Path;

        return $this;
    }
}
