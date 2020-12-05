<?php

namespace App\Entity;

class Rate
{
    private string $id;
    private float $rate;
    private Film $film;
    private User $user;

    public function __construct(float $rate, Film $film, User $user)
    {
        $this->rate = $rate;
        $this->film = $film;
        $this->user = $user;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function getMovie(): Film
    {
        return $this->film;
    }

    public function setFilm(Film $film): self
    {
        $this->film = $film;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}