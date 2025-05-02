<?php

namespace PHPico\Form\Support;

use PHPico\Support\Guard as BaseGuard;

class Guard extends BaseGuard
{

    public function csrf(): Csrf
    {
        return new Csrf();
    }

}