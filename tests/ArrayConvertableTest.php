<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use PHPUnit\Framework\TestCase;

use function array_intersect;

class ArrayConvertableTest extends TestCase
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
            'username' => 'midorikocak',
            'password' => '24738956349lhksbvlhf',
            'email' => 'mtkocak@gmail.com',
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->updatedUserData, $this->userData);
    }

    public function testFromArray(): void
    {
        $this->assertInstanceOf(User::class, User::fromArray($this->userData));
    }

    public function testToArray(): void
    {
        $user = new User(
            $this->userData['id'] ?? null,
            $this->userData['username'],
            $this->userData['email'],
            $this->userData['password']
        );

        $userArray = $user->toArray();

        $this->assertEquals($this->userData, array_intersect($this->userData, $userArray));

        $user->setId('2');

        $userArray = $user->toArray();

        $this->assertEquals($this->updatedUserData, $userArray);
    }
}
