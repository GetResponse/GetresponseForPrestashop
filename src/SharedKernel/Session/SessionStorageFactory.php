<?php

namespace GetResponse\SharedKernel\Session;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionStorageFactory
{
    public function create()
    {
        /** @var SessionInterface|null $session */
        $session = \Context::getContext()->session;
        if ($session) {
            return new SessionBasedStorage();
        }
        $storage = \Context::getContext()->session ? \Context::getContext()->cookie;
        return \Context::getContext()->se;
    }
}