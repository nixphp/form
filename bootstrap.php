<?php

use NixPHP\Form\Events\CsrfListener;
use function NixPHP\app;

app()
    ->container()
    ->get('event')
    ->listen(
        'controller.calling',
        [CsrfListener::class, 'handle']
    );
