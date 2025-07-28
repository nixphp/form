<?php

use NixPHP\Form\Events\CsrfListener;
use NixPHP\Form\Support\Csrf;
use function NixPHP\app;
use function NixPHP\guard;

guard()->register('csrf', new Csrf());

app()->container()->get('event')->listen('controller.calling', [CsrfListener::class, 'handle']);
