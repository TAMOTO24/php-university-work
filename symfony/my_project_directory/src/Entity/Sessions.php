<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\SessionsRepository')]
class Sessions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Exercises')]
    #[ORM\JoinColumn(name: 'exercise_id', referencedColumnName: 'id')]
    private ?Exercises $exercise = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\ClubMembers')]
    #[ORM\JoinColumn(name: 'trainer_id', referencedColumnName: 'id')]
    private ?ClubMembers $trainer = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date_time = null;

    #[ORM\Column(type: 'text')]
    private ?string $location = null;

    // Геттеры и сеттеры

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercise(): ?Exercises
    {
        return $this->exercise;
    }

    public function setExercise(?Exercises $exercise): self
    {
        $this->exercise = $exercise;
        return $this;
    }

    public function getTrainer(): ?ClubMembers
    {
        return $this->trainer;
    }

    public function setTrainer(?ClubMembers $trainer): self
    {
        $this->trainer = $trainer;
        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->date_time;
    }

    public function setDateTime(\DateTimeInterface $date_time): self
    {
        $this->date_time = $date_time;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }
}
