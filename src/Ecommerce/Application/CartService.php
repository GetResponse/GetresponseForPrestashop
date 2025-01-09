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

namespace GetResponse\Ecommerce\Application;

use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\Ecommerce\Application\Adapter\CartAdapter;
use GetResponse\Ecommerce\Application\Command\UpsertCart;
use GetResponse\MessageSender\Application\MessageSenderException;
use GetResponse\MessageSender\Application\MessageSenderService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartService
{
    /** @var MessageSenderService */
    private $messageSenderService;
    /** @var ConfigurationReadModel */
    private $configurationReadModel;

    public function __construct(
        MessageSenderService $messageSenderService,
        ConfigurationReadModel $configurationReadModel
    ) {
        $this->messageSenderService = $messageSenderService;
        $this->configurationReadModel = $configurationReadModel;
    }

    /**
     * @param UpsertCart $command
     *
     * @throws MessageSenderException
     */
    public function upsertCart(UpsertCart $command)
    {
        $configuration = $this->configurationReadModel->getConfigurationForShop($command->getShopId());

        if (false === $configuration->isEcommerceLiveSynchronizationActive()) {
            return;
        }

        $visitorUuid = null;
        if ($configuration->isGetResponseWebTrackingActive() && isset($_COOKIE['gaVisitorUuid'])) {
            $visitorUuid = $_COOKIE['gaVisitorUuid'];
        }

        $cartAdapter = new CartAdapter();
        $cart = $cartAdapter->getCartById($command->getCartId(), $visitorUuid);

        if ($cart->isValuable()) {
            $this->messageSenderService->send(
                $configuration->getLiveSynchronizationUrl(),
                $cart
            );
        }
    }
}
