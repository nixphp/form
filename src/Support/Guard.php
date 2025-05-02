<?php

namespace NixPHP\Form\Support;

use NixPHP\Support\Guard as BaseGuard;

class Guard extends BaseGuard
{

    public function csrf(): Csrf
    {
        return new Csrf();
    }

}