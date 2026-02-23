<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $testProp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestProp(): ?string
    {
        return $this->testProp;
    }

    public function setTestProp(?string $testProp): static
    {
        $this->testProp = $testProp;

        return $this;
    }
}
