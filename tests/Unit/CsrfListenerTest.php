<?php

namespace Tests\Unit;

use Nyholm\Psr7\ServerRequest;
use NixPHP\Form\Events\CsrfListener;
use NixPHP\Exceptions\AbortException;
use Tests\NixPHPTestCase;
use function NixPHP\Session\session;

class CsrfListenerTest extends NixPHPTestCase
{

    public function testSuccessful()
    {
        $this->expectNotToPerformAssertions();

        session()->start();
        $_SESSION['_csrf'] = 'test';
        $requestMock = new ServerRequest('POST', '/test');
        $requestMock = $requestMock->withParsedBody(['_csrf' => 'test']);
        $listener = new CsrfListener();
        $listener->handle($requestMock);
    }

    public function testShouldNotInterceptWithDifferentMethod()
    {
        $this->expectNotToPerformAssertions();

        $request = new ServerRequest('GET', '/test');
        $listener = new CsrfListener();
        $listener->handle($request);
    }

    public function testMissingCsrfToken()
    {
        $this->expectException(AbortException::class);

        $requestMock = new ServerRequest('POST', '/test');
        $listener = new CsrfListener();
        $listener->handle($requestMock);
    }

    public function testWrongCsrfToken()
    {
        $this->expectException(AbortException::class);

        session()->start();
        $_SESSION['_csrf'] = 'other';
        $requestMock = new ServerRequest('POST', '/test');
        $requestMock = $requestMock->withParsedBody(['_csrf' => 'test']);
        $listener = new CsrfListener();
        $listener->handle($requestMock);
    }

    public function testShouldIgnoreWhenAuthorizationHeaderIsPresent()
    {
        $this->expectNotToPerformAssertions();

        $requestMock = new ServerRequest('POST', '/test');
        $requestMock = $requestMock->withHeader('Authorization', 'Bearer test');
        $listener = new CsrfListener();
        $listener->handle($requestMock);
    }

}