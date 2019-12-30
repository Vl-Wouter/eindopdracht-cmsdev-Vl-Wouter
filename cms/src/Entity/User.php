<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"api", "login"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"api", "login"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"api", "login"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email
     * @Groups("api")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api", "employee", "login"})
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api", "employee", "login"})
     */
    private $last_name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"api", "login"})
     *
     */
    private $Cost;

    /**
     * @ORM\Column(type="float")
     * @Groups({"api", "login"})
     */
    private $transport;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Period", mappedBy="client", orphanRemoval=true)
     * @Groups("api")
     */
    private $periods;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="employee", orphanRemoval=true)
     * @Groups("api")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->periods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->Cost;
    }

    public function setCost(float $Cost): self
    {
        $this->Cost = $Cost;

        return $this;
    }

    public function getTransport(): ?float
    {
        return $this->transport;
    }

    public function setTransport(float $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return Collection|Period[]
     */
    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period)) {
            $this->periods[] = $period;
            $period->setClient($this);
        }

        return $this;
    }

    public function removePeriod(Period $period): self
    {
        if ($this->periods->contains($period)) {
            $this->periods->removeElement($period);
            // set the owning side to null (unless already changed)
            if ($period->getClient() === $this) {
                $period->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setEmployee($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getEmployee() === $this) {
                $task->setEmployee(null);
            }
        }

        return $this;
    }
}
