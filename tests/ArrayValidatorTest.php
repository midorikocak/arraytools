<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use PHPUnit\Framework\TestCase;

final class ArrayValidatorTest extends TestCase
{
    private ArrayValidator $arrayValidator;
    private $toValidate = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->toValidate = [
            'id' => 2,
            'username' => 'midorikocak',
            'password' => '24738956349lhksbvlhf',
            'email' => 'mtkocak@gmail.com',
        ];

        $this->arrayValidator = new ArrayValidator();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->toValidate, $this->arrayValidator);
    }

    public function testHasKeys(): void
    {
        $this->arrayValidator->hasKeys('id', 'password');
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));

        $this->arrayValidator->hasKeys('email', 'username');
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));

        $this->arrayValidator->hasKeys('hasan');
        $this->assertFalse($this->arrayValidator->validate($this->toValidate));
    }

    public function testSchema(): void
    {
        $schema = [
            'username' => 'string',
            'password' => 'string',
            'email' => 'email',
        ];

        $this->arrayValidator->schema($schema);
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));
    }

    public function testSchemaOneKey(): void
    {
        $schema = [
            'username' => 'string',
        ];

        $this->arrayValidator->schema($schema);
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));
    }

    public function testSchemaOneKeyFail(): void
    {
        $schema = [
            'username' => 'int',
        ];

        $this->arrayValidator->schema($schema);
        $this->assertFalse($this->arrayValidator->validate($this->toValidate));
    }

    public function testSchemaFail(): void
    {
        $schema = [
            'username' => 'string',
            'password' => 'string',
            'email' => 'float',
        ];

        $this->arrayValidator->schema($schema);
        $this->assertFalse($this->arrayValidator->validate($this->toValidate));
    }

    public function testHasKey(): void
    {
        $this->arrayValidator->hasKey('id');
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));

        $this->arrayValidator->hasKey('hasan');
        $this->assertFalse($this->arrayValidator->validate($this->toValidate));
    }

    public function testKeysEqual(): void
    {
        $this->arrayValidator->keys('id', 'password', 'email', 'username');
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));

        $this->arrayValidator->keys('id', 'password', 'email');
        $this->assertFalse($this->arrayValidator->validate($this->toValidate));
    }

    public function testKeyNotEmpty(): void
    {
        $this->arrayValidator->notEmpty('id');
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));
    }

    public function testKeysNotEmpty(): void
    {
        $this->arrayValidator->notEmpty('id', 'password', 'username');
        $this->assertTrue($this->arrayValidator->validate($this->toValidate));
    }
}
