<?php

namespace App\Entity;

use App\Repository\ProdyctsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdyctsRepository::class)]
class Prodycts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?int $prise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPrise(): ?int
    {
        return $this->prise;
    }

    public function setPrise(int $prise): self
    {
        $this->prise = $prise;

        return $this;
    }
}
