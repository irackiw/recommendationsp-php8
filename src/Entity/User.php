<?php

namespace App\Entity;

class User
{
    private string $id;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
