<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\MembershipsRepository')]
class Memberships
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $member_id = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\ClubMembers')]
    #[ORM\JoinColumn(name: 'member_id', referencedColumnName: 'id')]
    private ?ClubMembers $member = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Sessions')]
    #[ORM\JoinColumn(name: 'session_id', referencedColumnName: 'id')]
    private ?Sessions $session = null;

    // Геттеры и сеттеры

    public function getMemberId(): ?int
    {
        return $this->member_id;
    }

    public function getMember(): ?ClubMembers
    {
        return $this->member;
    }

    public function setMember(?ClubMembers $member): self
    {
        $this->member = $member;
        return $this;
    }

    public function getSession(): ?Sessions
    {
        return $this->session;
    }

    public function setSession(?Sessions $session): self
    {
        $this->session = $session;
        return $this;
    }
}
