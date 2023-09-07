<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['json_base'])]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['json_base'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: "team1", targetEntity: Matchh::class, cascade: ["remove"])]
    private $matchesAsTeam1;

    #[ORM\OneToMany(mappedBy: "team2", targetEntity: Matchh::class, cascade: ["remove"])]
    private $matchesAsTeam2;

    public function __construct()
    {
        $this->matchesAsTeam1 = new ArrayCollection();
        $this->matchesAsTeam2 = new ArrayCollection();
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}

