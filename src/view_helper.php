<?php

namespace NixPHP\Form;

use NixPHP\Form\Core\Validator;
use Psr\Http\Message\ServerRequestInterface;
use function NixPHP\app;

function memory(string $key, mixed $default = null):? string
{
    /* @var ServerRequestInterface $request */
    $request = app()->container()->get('request');
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
    $input = memory($key);
    return $input === $value ? 'checked' : '';
}

function memory_selected(string $key, mixed $expectedValue): string
{
    $input = memory($key);
    return $input == $expectedValue ? 'selected' : '';
}

function validator($data, $rules): Validator
{
    return new Validator($data, $rules);
}

function form_error($field)
{

}