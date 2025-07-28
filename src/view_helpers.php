<?php

namespace NixPHP\Form;

use NixPHP\Form\Core\Validator;
use NixPHP\Form\Support\Csrf;
use function NixPHP\app;
use function NixPHP\param;
use function NixPHP\guard;

function memory(string $key, mixed $default = null):? string
{
    return param()->get($key);
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

function error($field, Validator $validator):? string
{
    if (!is_post()) {
        return null;
    }

    if (isset($validator->errors()[$field])) {
        return '<div class="error-msg">' . implode(PHP_EOL, $validator->getError($field)) . '</div>';
    }

    return null;
}

function has_error($field, Validator $validator): bool
{
    return error($field, $validator) !== null;
}

function error_class($field, Validator $validator): string
{
    return has_error($field, $validator) ? 'error' : '';
}

function is_post(): bool
{
    return app()->container()->get('request')->getMethod() === 'POST';
}

function csrf(): Csrf
{
    return guard()->csrf();
}