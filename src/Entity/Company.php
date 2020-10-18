<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Ads::class, mappedBy="company")
     */
    private $jobads;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="company")
     */
    private $contact;

    public function __construct()
    {
        $this->jobads = new ArrayCollection();
        $this->contact = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Ads[]
     */
    public function getJobads(): Collection
    {
        return $this->jobads;
    }

    public function addJobad(Ads $jobad): self
    {
        if (!$this->jobads->contains($jobad)) {
            $this->jobads[] = $jobad;
            $jobad->setCompany($this);
        }

        return $this;
    }

    public function removeJobad(Ads $jobad): self
    {
        if ($this->jobads->contains($jobad)) {
            $this->jobads->removeElement($jobad);
            // set the owning side to null (unless already changed)
            if ($jobad->getCompany() === $this) {
                $jobad->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(User $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
            $contact->setCompany($this);
        }

        return $this;
    }

    public function removeContact(User $contact): self
    {
        if ($this->contact->contains($contact)) {
            $this->contact->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getCompany() === $this) {
                $contact->setCompany(null);
            }
        }

        return $this;
    }
}
