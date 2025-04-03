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

use Symfony\Component\HttpFoundation\Session\SessionInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SessionStorage implements Storage
{
    /** @var SessionInterface */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function exists(string $keyName): bool
    {
        return $this->session->has($keyName);
    }

    public function set(string $keyName, $payload): void
    {
        $this->session->set($keyName, base64_encode((string) $payload));
    }

    public function remove(string $keyName): void
    {
        $this->session->remove($keyName);
    }

    public function get(string $keyName)
    {
        if (!$this->exists($keyName)) {
            return null;
        }

        return base64_decode((string) $this->session->get($keyName));
    }
}
