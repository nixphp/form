<?php

declare(strict_types=1);

use NixPHP\Form\Core\Validator;
use NixPHP\Form\Events\CsrfListener;
use NixPHP\Form\Support\Csrf;
use NixPHP\Core\EventManager;
use NixPHP\Core\Event;
use function NixPHP\app;
use function NixPHP\guard;

guard()->register('csrf', function() {
    return new Csrf();
});

app()->container()->set(Validator::class, function() {

    Validator::register('required', fn($val) => !empty($val), 'Field is required.');
    Validator::register('email', fn($val) => (bool)filter_var($val, FILTER_VALIDATE_EMAIL), 'Please enter a valid email address.');
    Validator::register('min', fn($val, $p) => empty($val) || mb_strlen((string)$val) >= (int)$p, 'At least %d characters.');
    Validator::register('max', fn($val, $p) => empty($val) || mb_strlen((string)$val) <= (int)$p, 'Maximum of %d characters.');
    Validator::register('boolean', fn($val) => filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null, 'Is not a boolean value.');

    return new Validator();

});

app()->container()->get(EventManager::class)
    ->listen(Event::CONTROLLER_CALLING, [CsrfListener::class, 'handle']);
