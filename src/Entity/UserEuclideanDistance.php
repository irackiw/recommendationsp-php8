<?php

namespace App\Entity;

class UserEuclideanDistance
{
    private string $id;
    private User $from;
    private User $to;
    private float $score;

    public function __construct(User $from, User $to, float $score)
    {
        $this->from = $from;
        $this->to = $to;
        $this->score = $score;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getTo(): User
    {
        return $this->to;
    }

    public function getScore(): float
    {
        return $this->score;
    }
}