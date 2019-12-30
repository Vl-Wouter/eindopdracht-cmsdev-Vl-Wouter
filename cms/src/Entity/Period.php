<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeriodRepository")
 */
class Period
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="periods")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"api", "employee"})
     */
    private $client;

    /**
     * @ORM\Column(type="date")
     */
    private $start_date;


    /**
     * @ORM\Column(type="date")
     */
    private $end_date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="period", orphanRemoval=true)
     */
    private $tasks;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Remark", mappedBy="period")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Remark", mappedBy="period")
     */
    private $remarks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->content = new ArrayCollection();
        $this->remarks = new ArrayCollection();
    }

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

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
            $task->setPeriod($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getPeriod() === $this) {
                $task->setPeriod(null);
            }
        }

        return $this;
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * @return Collection|Remark[]
     */
    public function getContent(): Collection
    {
        return $this->content;
    }

    public function addContent(Remark $content): self
    {
        if (!$this->content->contains($content)) {
            $this->content[] = $content;
            $content->setPeriod($this);
        }

        return $this;
    }

    public function removeContent(Remark $content): self
    {
        if ($this->content->contains($content)) {
            $this->content->removeElement($content);
            // set the owning side to null (unless already changed)
            if ($content->getPeriod() === $this) {
                $content->setPeriod(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Remark[]
     */
    public function getRemarks(): Collection
    {
        return $this->remarks;
    }

    public function addRemark(Remark $remark): self
    {
        if (!$this->remarks->contains($remark)) {
            $this->remarks[] = $remark;
            $remark->setPeriod($this);
        }

        return $this;
    }

    public function removeRemark(Remark $remark): self
    {
        if ($this->remarks->contains($remark)) {
            $this->remarks->removeElement($remark);
            // set the owning side to null (unless already changed)
            if ($remark->getPeriod() === $this) {
                $remark->setPeriod(null);
            }
        }

        return $this;
    }
}
