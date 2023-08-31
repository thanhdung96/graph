<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Department
{
    #[ORM\Id]
    #[ORM\Column(length: 36, unique: true)]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Employee::class)]
    private Collection $supervisors;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modified = null;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Employee::class)]
    private Collection $members;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deleted = null;

    public function __construct()
    {
        $this->supervisors = new ArrayCollection();
        $this->members = new ArrayCollection();

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

    /**
     * @return Collection<int, Employee>
     */
    public function getSupervisors(): Collection
    {
        return $this->supervisors;
    }

    public function addSupervisor(Employee $supervisor): static
    {
        if (!$this->supervisors->contains($supervisor)) {
            $this->supervisors->add($supervisor);
            $supervisor->setDepartmentSupervised($this);
        }

        return $this;
    }

    public function removeSupervisor(Employee $supervisor): static
    {
        if ($this->supervisors->removeElement($supervisor)) {
            // set the owning side to null (unless already changed)
            if ($supervisor->getDepartmentSupervised() === $this) {
                $supervisor->setDepartmentSupervised(null);
            }
        }

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

    /**
     * @return Collection<int, Employee>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Employee $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setDepartment($this);
        }

        return $this;
    }

    public function removeMember(Employee $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getDepartment() === $this) {
                $member->setDepartment(null);
            }
        }

        return $this;
    }
}
