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

class CookieStorage implements Storage
{
    private $context;

    /** @var Cookie $storage */
    public function __construct($storage)
    {
        $this->context = \Context::getContext();
    }

    public function exists($keyName)
    {
        return (bool) $this->context->cookie->__isset($keyName);
    }

    public function set($keyName, $payload)
    {
        $this->context->cookie->__set($keyName, base64_encode($payload));
    }

    public function remove($keyName)
    {
        $this->context->cookie->__unset($keyName);
    }

    public function get($keyName)
    {
        if (false === $this->exists($keyName)) {
            return null;
        }

        return base64_decode($this->context->cookie->__get($keyName));
    }
}
