<?php

namespace GetResponse\SharedKernel\Session;

use RuntimeException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionStorageFactory
{
    public function create()
    {
        $context = \Context::getContext();

        /** @var SessionInterface|null $session */
        $session = $context->session;

        if ($session instanceof SessionInterface) {
            return new SessionBasedStorage($session);
        }

        if ($context->cookie) {
            return new CookieBasedStorage($context->cookie);
        }

        throw new RuntimeException('No suitable storage available in the current context.');
    }
}