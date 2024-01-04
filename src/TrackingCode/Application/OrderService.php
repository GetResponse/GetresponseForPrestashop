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

use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\TrackingCode\Application\Adapter\CartAdapter;
use GetResponse\TrackingCode\Application\Adapter\OrderAdapter;
use GetResponse\TrackingCode\Application\Command\AddCartToBuffer;
use GetResponse\TrackingCode\DomainModel\Order;
use GetResponse\TrackingCode\DomainModel\TrackingCodeBufferService;

class OrderService
{
    /** @var ConfigurationReadModel */
    private $configurationReadModel;
    /** @var TrackingCodeBufferService */
    private $service;

    public function __construct(ConfigurationReadModel $configurationReadModel, TrackingCodeBufferService $service)
    {
        $this->configurationReadModel = $configurationReadModel;
        $this->service = $service;
    }

    /**
     * @param int $orderId
     * @param int $shopId
     */
    public function addOrderToBuffer($orderId, $shopId)
    {
        $configuration = $this->configurationReadModel->getConfigurationForShop($shopId);

        if (false === $configuration->isGetResponseWebTrackingActive()) {
            return;
        }

        $orderAdapter = new OrderAdapter();
        $order = $orderAdapter->getOrderById($orderId);

        if ($order->isValuable()) {
            $this->service->addOrderToBuffer($order);
        }
    }

    /**
     * @param int $shopId
     * @return Order|null
     */
    public function getOrderFromBuffer($shopId)
    {
        $configuration = $this->configurationReadModel->getConfigurationForShop($shopId);

        if (false === $configuration->isGetResponseWebTrackingActive()) {
            return null;
        }

        return $this->service->getOrderFromBuffer();
    }
}
