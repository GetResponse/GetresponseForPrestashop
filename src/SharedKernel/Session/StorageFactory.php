<?php

namespace GetResponse\SharedKernel\Session;

use RuntimeException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StorageFactory
{
    public function create()
    {
        try {
            $context = \Context::getContext();

            /** @var SessionInterface|null $session */
            $session = $context->session;

            if ($session instanceof SessionInterface) {
                return new SessionStorage($session);
            }

            if ($context->cookie) {
                return new CookieStorage($context->cookie);
            }
        } catch (RuntimeException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    /**
     * @param string $message
     */
    private function logGetResponseError($message)
    {
        PrestaShopLoggerCore::addLog($message, 2, null, 'GetResponse', 'GetResponse');
    }
}