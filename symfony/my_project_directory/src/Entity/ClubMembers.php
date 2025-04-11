<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'club_members')]
class ClubMembers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $full_name;

    #[ORM\Column(type: 'text')]
    private $login;

    #[ORM\Column(type: 'boolean')]
    private $isTrainer;

    #[ORM\Column(type: 'text')]
    private $mail;

    // Геттеры и сеттеры

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;
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

    public function getIsTrainer(): ?bool
    {
        return $this->isTrainer;
    }

    public function setIsTrainer(bool $isTrainer): self
    {
        $this->isTrainer = $isTrainer;
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
}

