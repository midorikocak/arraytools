# Array Tools

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Handy array tools to creating and updating objects from arrays, converting objects to arrays and validating them.

## Requirements

Strictly requires PHP 7.4.

## Install

Via Composer

``` bash
$ composer require midorikocak/arraytools
```

## Usage 

### Object and Array Conversion

Let's say you have a plain data object like this:
    
```php

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

    // Getters and setters
``` 

In order to convert this object to an array you should implement methods like `toArray` and  `fromArray` like this.

```php
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
```

This would make may problems in case of change and resposibility. Instead you can use `ArrayConvertableTrait` in your data object implemetation.

    
```php
<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

class User implements ArrayConvertableInterface
{
    use ArrayConvertableTrait;

    private ?string $id;
    private string $username;
    private string $email;
    private string $password;

    // rest
``` 

Simply calling `toArray()` method from your object will return an array with your constructor params and their names as array keys. 

***Note:*** Trait expects that implemented object has getters.

    
```php
$userData = [
    'username' => 'midorikocak',
    'password' => '24738956349lhksbvlhf',
    'email' => 'mtkocak@gmail.com',
];


$user = new User(
    $userData['id'] ?? null,
    $userData['username'],
    $userData['email'],
    $userData['password']
);

$userArray = $user->toArray();
print_r($userArray);
``` 

Will output to:

``` 
Array
(
    [username] => midorikocak
    [password] => 24738956349lhksbvlhf
    [email] => mtkocak@gmail.com
)

``` 

#### fromArray

`ArrayConvertableTrait` also adds `fromArray` functionality into your object. It expects that the array has same keys with constructor parameters.
    
```php

$userData = [
    'username' => 'midorikocak',
    'password' => '24738956349lhksbvlhf',
    'email' => 'mtkocak@gmail.com',
];
        
$user = User::fromArray($userData);
``` 

### Object update using array data

If you use `ArrayUpdateableTrait` you can use  `setFromArray()` method into your object. It will update object instance with array data.

***Note:*** It expects that the array has same keys with setters.
    
```php

$userData = [
    'id' => '2',
    'username' => 'update',
    'password' => 'updatedpw',
    'email' => 'updated@email.com',
];
        
$user->setFromArray($userData);
``` 

### Array Validation

You can use `ArrayValidator` class to validate your arrays according to the rules you define. 
    
```php
use midorikocak\arraytools\ArrayValidator;

$arrayValidator = new ArrayValidator();
```

#### Array should have a key

    
```php
use midorikocak\arraytools\ArrayValidator;

$toValidate = [
    'id'=>'1',
    'username'=>'uname',
    'password'=>''
];

$arrayValidator = new ArrayValidator();
$arrayValidator->hasKey('id');
echo $arrayValidator->validate($toValidate); // true

$arrayValidator->hasKey('hasan');
echo $arrayValidator->validate($toValidate); // false
```

#### Array should contain keys

    
```php
$arrayValidator->hasKeys('id', 'username');
echo $arrayValidator->validate($toValidate); // true
```

#### Array should exactly have keys

    
```php
$arrayValidator->keys('id', 'username', 'password');
echo $arrayValidator->validate($toValidate); // true
```

#### Array should defined keys shouldn't be empty
    
```php
$arrayValidator->notEmpty('password');
echo $arrayValidator->validate($toValidate); // false
```

#### Rules are chainable
    
```php
echo $arrayValidator
        ->keys('id', 'username', 'password')
        ->notEmpty('password')
        ->hasKeys('id', 'username')
        ->validate($toValidate); // false
```

#### Array can conform the defined schema

A simple schema structure can be used for checking array values. Schema values can be one of  `boolean`, `domain`, `int`, `email`, `mac`, `float`, `regexp` and `string`.
    
```php
$schema = [
    'username' => 'string',
    'password' => 'string',
    'email' => 'email',
];

$arrayValidator->schema($schema); // true
```

#### Array can conform user supplied function

A function that accepts an array and returns bool value can be appended to last validation.

```php
echo $arrayValidator->validate($toValidate, function($array){
    return array_key_exists('key', $array);
}); // false
```

## Custom Validators

To create custom validators, you may extend `AbstractValidator` class. Please check the source for details.

## Motivation and Warning

Mostly educational purposes. Please use at your own risk.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email mtkocak@gmail.com instead of using the issue tracker.

## Credits

- [Midori Kocak][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/midorikocak/arraytools.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/midorikocak/arraytools/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/midorikocak/arraytools.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/midorikocak/arraytools.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/midorikocak/arraytools.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/midorikocak/arraytools
[link-travis]: https://travis-ci.org/midorikocak/arraytools
[link-scrutinizer]: https://scrutinizer-ci.com/g/midorikocak/arraytools/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/midorikocak/arraytools
[link-downloads]: https://packagist.org/packages/midorikocak/arraytools
[link-author]: https://github.com/midorikocak
[link-contributors]: ../../contributors
