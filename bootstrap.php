<?php

require_once __DIR__ . '/vendor/autoload.php';

use PHPico\Form\Events\CsrfListener;
use PHPico\Form\Support\Guard;
use function PHPico\app;

app()->container()->set('guard', function () { return new Guard(); });
app()->container()->get('event')->listen('controller.calling', [CsrfListener::class, 'handle']);
