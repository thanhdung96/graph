<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(length: 36, unique: true)]
    private string $id;

    #[ORM\ManyToOne(inversedBy: 'supervisors')]
    private ?Department $departmentSupervised = null;

    #[ORM\ManyToOne(inversedBy: 'members')]
    private ?Department $department = null;

    #[ORM\Column(length: 32)]
    private ?string $firstName = null;

    #[ORM\Column(length: 32)]
    private ?string $lastName = null;

    #[ORM\Column]
    private ?bool $gender = null;

    #[ORM\Column]
    private ?float $salary = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $motorBrand = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $plateNumber = null;

    #[ORM\Column(length: 16)]
    private ?string $nationality = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modified = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deleted = null;

    #[ORM\OneToMany(mappedBy: 'assignee', targetEntity: Device::class)]
    private Collection $devices;

    public function __construct()
    {
        $timestamp = new \DateTime();
        $this->created = $timestamp;
        $this->modified = $timestamp;
        $this->id = Uuid::v7()->generate($timestamp);
        $this->devices = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDepartmentSupervised(): ?Department
    {
        return $this->departmentSupervised;
    }

    public function setDepartmentSupervised(?Department $departmentSupervised): static
    {
        $this->departmentSupervised = $departmentSupervised;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getMotorBrand(): ?string
    {
        return $this->motorBrand;
    }

    public function setMotorBrand(?string $motorBrand): static
    {
        $this->motorBrand = $motorBrand;

        return $this;
    }

    public function getPlateNumber(): ?string
    {
        return $this->plateNumber;
    }

    public function setPlateNumber(?string $plateNumber): static
    {
        $this->plateNumber = $plateNumber;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

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
     * @return Collection<int, Device>
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): static
    {
        if (!$this->devices->contains($device)) {
            $this->devices->add($device);
            $device->setAssignee($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): static
    {
        if ($this->devices->removeElement($device)) {
            // set the owning side to null (unless already changed)
            if ($device->getAssignee() === $this) {
                $device->setAssignee(null);
            }
        }

        return $this;
    }
}
