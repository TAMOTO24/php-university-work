<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ExercisesRepository')]
class Exercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\ClubMembers')]
    #[ORM\JoinColumn(name: 'trainerID', referencedColumnName: 'id')]
    private ?ClubMembers $trainer = null;

    #[ORM\Column(type: 'text')]
    private ?string $exercise = null;

    #[ORM\Column(type: 'bigint')]
    private ?int $time = null;

    #[ORM\Column(type: 'text')]
    private ?string $title = null;

    public function getTrainer(): ?ClubMembers
    {
        return $this->trainer;
    }

    public function setTrainer(?ClubMembers $trainer): self
    {
        $this->trainer = $trainer;
        return $this;
    }
    public function getId(): ?int
{
    return $this->id;
}

    public function getExercise(): ?string
    {
        return $this->exercise;
    }

    public function setExercise(string $exercise): self
    {
        $this->exercise = $exercise;
        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
