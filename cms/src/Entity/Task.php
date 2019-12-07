<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $begin_time;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $end_time;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $break;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $activity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $materials;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $transport_distance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

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
}
