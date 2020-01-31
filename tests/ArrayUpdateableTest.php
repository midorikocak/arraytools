<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use PHPUnit\Framework\TestCase;

class ArrayUpdateableTest extends TestCase
{
    private array $updatedUserData;
    private array $userData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'username' => 'midorikocak',
            'password' => '24738956349lhksbvlhf',
            'email' => 'mtkocak@gmail.com',
        ];

        $this->updatedUserData = [
            'id' => '2',
            'username' => 'updated',
            'password' => 'updatedpw',
            'email' => 'updated@email.com',
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->updatedUserData, $this->userData);
    }

    public function testSetFromArray(): void
    {
        $user = new User(
            $this->userData['id'] ?? null,
            $this->userData['username'],
            $this->userData['email'],
            $this->userData['password']
        );

        $user->setFromArray($this->updatedUserData);

        $this->assertEquals($this->updatedUserData['id'], $user->getId());
        $this->assertEquals($this->updatedUserData['email'], $user->getEmail());
        $this->assertEquals($this->updatedUserData['password'], $user->getPassword());
        $this->assertEquals($this->updatedUserData['username'], $user->getUsername());
    }
}
