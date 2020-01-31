<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

abstract class AbstractUser implements ArrayConvertableInterface
{
    abstract public function getUsername(): string;

    abstract public function getEmail(): string;

    abstract public function getPassword(): string;

    abstract public function getId(): ?string;

    public function toArray(): array
    {
        $toReturn = [
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
        ];

        if ($this->getId()) {
            $toReturn['id'] = $this->getId();
        }

        return $toReturn;
    }

    public static function fromArray($array): User
    {
        $id = $array['id'] ?? null;
        $username = $array['username'];
        $email = $array['email'];
        $password = $array['password'];

        return new User($id, $username, $email, $password);
    }
}
