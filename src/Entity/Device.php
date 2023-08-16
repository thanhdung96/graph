<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(length: 36, unique: true)]
    private string $id;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(length: 32)]
    private ?string $Brand = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $purchaseDate = null;

    #[ORM\Column(length: 16)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modified = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deleted = null;

    #[ORM\ManyToOne(inversedBy: 'devices')]
    private ?Employee $assignee = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): static
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?\DateTimeInterface $purchaseDate): static
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): static
    {
        $this->modified = $modified;

        return $this;
    }

    public function getDeleted(): ?\DateTimeInterface
    {
        return $this->deleted;
    }

    public function setDeleted(?\DateTimeInterface $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function __construct()
    {
        $timestamp = new \DateTime();
        $this->created = $timestamp;
        $this->modified = $timestamp;
        $this->id = Uuid::v7()->generate($timestamp);
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $timestamp = new \DateTime();

        $this->modified = $timestamp;
        if(is_null($this->created)) {
            $this->created = $timestamp;
        }
    }

    public function getAssignee(): ?Employee
    {
        return $this->assignee;
    }

    public function setAssignee(?Employee $assignee): static
    {
        $this->assignee = $assignee;

        return $this;
    }
}
