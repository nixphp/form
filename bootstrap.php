<?php

use NixPHP\Form\Core\Validator;
use NixPHP\Form\Events\CsrfListener;
use NixPHP\Form\Support\Csrf;
use function NixPHP\app;
use function NixPHP\guard;

guard()->register('csrf', function() {
    return new Csrf();
});

app()->container()->set('validator', function() {

    Validator::register('required', fn($val) => !empty($val), 'Field is required.');
    Validator::register('email', fn($val) => (bool)filter_var($val, FILTER_VALIDATE_EMAIL), 'Please enter a valid email address.');
    Validator::register('min', fn($val, $p) => empty($val) || mb_strlen((string)$val) >= (int)$p, 'At least %d characters.');
    Validator::register('max', fn($val, $p) => empty($val) || mb_strlen((string)$val) <= (int)$p, 'Maximum of %d characters.');
    Validator::register('boolean', fn($val) => is_bool($val), 'Is not boolean value.');

    return new Validator();

});

app()->container()->get('event')->listen('controller.calling', [CsrfListener::class, 'handle']);
