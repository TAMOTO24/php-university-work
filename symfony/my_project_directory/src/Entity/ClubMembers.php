<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ClubMembersRepository')]
class ClubMembers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $fullName = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $login = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $mail = null;

    #[ORM\Column(type: 'boolean')]
    private bool $is_trainer = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function isTrainer(): bool
    {
        return $this->is_trainer;
    }

    public function setIsTrainer(bool $is_trainer): self
    {
        $this->is_trainer = $is_trainer;
        return $this;
    }
}
