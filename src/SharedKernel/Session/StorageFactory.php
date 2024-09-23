<?php

namespace GetResponse\SharedKernel\Session;

use RuntimeException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StorageFactory
{
    public function create()
    {
        $context = \Context::getContext();

        /** @var SessionInterface|null $session */
        $session = $context->session;

        if ($session instanceof SessionInterface) {
            return new SessionStorage($session);
        }

        if ($context->cookie) {
            return new CookieStorage($context->cookie);
        }

        throw new RuntimeException('No suitable storage available in the current context.');
    }
}