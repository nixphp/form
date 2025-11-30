<?php

declare(strict_types=1);

namespace Tests;

use NixPHP\Form\Core\Validator;
use PHPUnit\Framework\TestCase;

class NixPHPTestCase extends TestCase
{

    protected function tearDown(): void
    {
        // Reset the static registry after each test
        $reflection = new \ReflectionClass(Validator::class);
        $property = $reflection->getProperty('registry');
        $property->setAccessible(true);
        $property->setValue(null, []);
        parent::tearDown();
    }

}