<?php

namespace App\Entity;

use App\Repository\ChampionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChampionRepository::class)
 */
class Champion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $tips;

    /**
     * @ORM\Column(type="text")
     */
    private $startingItem;

    /**
     * @ORM\Column(type="integer")
     */
    private $difficulty;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cooldowns;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

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

    public function getTips(): ?string
    {
        return $this->tips;
    }

    public function setTips(string $tips): self
    {
        $this->tips = $tips;

        return $this;
    }

    public function getStartingItem(): ?string
    {
        return $this->startingItem;
    }

    public function setStartingItem(string $startingItem): self
    {
        $this->startingItem = $startingItem;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getCooldowns(): ?string
    {
        return $this->cooldowns;
    }

    public function setCooldowns(string $cooldowns): self
    {
        $this->cooldowns = $cooldowns;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
