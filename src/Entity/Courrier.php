<?php

namespace App\Entity;

use App\Repository\CourrierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourrierRepository::class)
 */
class Courrier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateEnvoie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ObjetCourrier;

    /**
     * @ORM\Column(type="text")
     */
    private $Message;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $TypeCourrier;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estValidE;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_read = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="received")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recipient;

    public function __construct()
    {
        $this->DateEnvoie= new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->DateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $DateEnvoie): self
    {
        $this->DateEnvoie = $DateEnvoie;

        return $this;
    }

    public function getObjetCourrier(): ?string
    {
        return $this->ObjetCourrier;
    }

    public function setObjetCourrier(string $ObjetCourrier): self
    {
        $this->ObjetCourrier = $ObjetCourrier;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

    public function getTypeCourrier(): ?string
    {
        return $this->TypeCourrier;
    }

    public function setTypeCourrier(string $TypeCourrier): self
    {
        $this->TypeCourrier = $TypeCourrier;

        return $this;
    }

    public function getEstValidE(): ?bool
    {
        return $this->estValidE;
    }

    public function setEstValidE(bool $estValidE): self
    {
        $this->estValidE = $estValidE;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): self
    {
        $this->is_read = $is_read;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

}