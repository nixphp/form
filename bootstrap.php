<?php

use NixPHP\Form\Events\CsrfListener;
use NixPHP\Form\Support\Guard;
use function NixPHP\app;

app()->container()->set('guard', function () { return new Guard(); });
app()->container()->get('event')->listen('controller.calling', [CsrfListener::class, 'handle']);
