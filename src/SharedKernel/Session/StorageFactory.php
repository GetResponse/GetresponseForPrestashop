<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace GetResponse\SharedKernel\Session;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StorageFactory
{
    /**
     * @return SessionStorage|CookieStorage|null
     */
    public function create()
    {
        try {
            $context = \Context::getContext();

            if ($context === null) {
                throw new \RuntimeException('Context is null');
            }

            if (isset($context->session) && $context->session instanceof SessionInterface) {
                return new SessionStorage($context->session);
            }

            if (isset($context->cookie)) {
                return new CookieStorage();
            }
        } catch (\RuntimeException $e) {
            $this->logGetResponseError($e->getMessage());
        }

        return null;
    }

    /**
     * @param string $message
     *
     * @return void
     */
    private function logGetResponseError(string $message): void
    {
        \PrestaShopLogger::addLog($message, 2, null, 'GetResponse');
    }
}
