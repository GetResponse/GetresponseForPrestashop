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

namespace GetResponse\TrackingCode\Application;

use Cart as PrestashopCart;
use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\TrackingCode\Application\Adapter\CartAdapter;
use GetResponse\TrackingCode\DomainModel\Cart;
use GetResponse\TrackingCode\DomainModel\TrackingCodeBufferService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartService
{
    /** @var ConfigurationReadModel */
    private $configurationReadModel;
    /** @var TrackingCodeBufferService */
    private $service;
    /** @var \Link */
    private $link;

    public function __construct(
        ConfigurationReadModel $configurationReadModel,
        TrackingCodeBufferService $service,
        \Link $link
    ) {
        $this->configurationReadModel = $configurationReadModel;
        $this->service = $service;
        $this->link = $link;
    }

    public function setLastCartHash(string $cartHash): void
    {
        $this->service->setLastCartHash($cartHash);
    }

    public function getCartForWebconnect(PrestashopCart $prestashopCart, int $shopId): ?Cart
    {
        $configuration = $this->configurationReadModel->getConfigurationForShop($shopId);

        if (false === $configuration->isGetResponseWebTrackingActive()) {
            return null;
        }

        $cartAdapter = new CartAdapter($this->link);
        $cart = $cartAdapter->getCartByPrestashopCart($prestashopCart);

        if (!$cart->isValuable() || $cart->getHash() === $this->service->getLastCartHash()) {
            return null;
        }

        return $cart;
    }
}
