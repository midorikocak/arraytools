<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

class User implements ArrayConvertableInterface, ArrayUpdateableInterface
{
    use ArrayConvertableTrait;
    use ArrayUpdateableTrait;

    private ?string $id;
    private string $username;
    private string $email;
    private string $password;

    public function __construct(?string $id, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }
}
