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
use GetResponse\TrackingCode\Application\Adapter\OrderAdapter;
use GetResponse\TrackingCode\DomainModel\Order;
use GetResponse\TrackingCode\DomainModel\TrackingCodeBufferService;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     *
     * @return void
     */
    public function addOrderToBuffer(int $orderId, int $shopId): void
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
     *
     * @return Order|null
     */
    public function getOrderFromBuffer(int $shopId): ?Order
    {
        $configuration = $this->configurationReadModel->getConfigurationForShop($shopId);

        if (false === $configuration->isGetResponseWebTrackingActive()) {
            return null;
        }

        return $this->service->getOrderFromBuffer();
    }
}
