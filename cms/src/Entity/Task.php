<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"api", "employee"})
     */
    private $id;


    /**
     * @ORM\Column(type="date")
     * @Groups({"api", "employee"})
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Assert\Time()
     * @Groups({"api", "employee"})
     */
    private $begin_time;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Assert\Time()
     * @Groups({"api", "employee"})
     */
    private $end_time;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("api")
     */
    private $break;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"api", "employee"})
     */
    private $activity;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("api")
     */
    private $materials;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("api")
     */
    private $transport_distance;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("api")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"api", "employee"})
     */
    private $status = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Period", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"api", "employee"})
     */
    private $period;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api")
     */
    private $employee;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"api", "employee"})
     */
    private $Cost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getBeginTime(): ?\DateTimeInterface
    {
        return $this->begin_time;
    }

    public function setBeginTime(\DateTimeInterface $begin_time): self
    {
        $this->begin_time = $begin_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getBreak(): ?float
    {
        return $this->break;
    }

    public function setBreak(float $break): self
    {
        $this->break = $break;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->materials;
    }

    public function setMaterials(string $materials): self
    {
        $this->materials = $materials;

        return $this;
    }

    public function getTransportDistance(): ?int
    {
        return $this->transport_distance;
    }

    public function setTransportDistance(?int $transport_distance): self
    {
        $this->transport_distance = $transport_distance;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPeriod(): ?Period
    {
        return $this->period;
    }

    public function setPeriod(?Period $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->Cost;
    }

    public function setCost(?float $Cost): self
    {
        $this->Cost = $Cost;

        return $this;
    }
}
