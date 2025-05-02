<?php

namespace PHPIco\Form;

use PHPico\Form\Core\Validator;
use function PHPico\app;

function memory(string $key, mixed $default = null):? string
{
    $request = app()->request();
    $parsedBody = $request->getParsedBody();
    $queryParams = $request->getQueryParams();

    // parsedBody kann null sein (bei GET-Requests)
    if (is_array($parsedBody) && array_key_exists($key, $parsedBody)) {
        return $parsedBody[$key];
    }

    // Fallback auf Query-Parameter
    return $queryParams[$key] ?? $default;
}

function memory_checked(string $key, mixed $value = 'on'): string
{
    $input = \PHPico\Form\memory($key);
    return $input === $value ? 'checked' : '';
}

function memory_selected(string $key, mixed $expectedValue): string
{
    $input = memory($key);
    return $input == $expectedValue ? 'selected' : '';
}

function validator($data, $rules)
{
    return new Validator($data, $rules);
}

function form_error($field)
{

}