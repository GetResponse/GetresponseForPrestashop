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

namespace GetResponse\Contact\Application;

use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\Contact\Application\Adapter\CustomerAdapter;
use GetResponse\Contact\Application\Command\UpsertCustomer;
use GetResponse\Contact\Application\Command\UpsertSubscriber;
use GetResponse\Contact\DomainModel\Subscriber;
use GetResponse\MessageSender\Application\MessageSenderException;
use GetResponse\MessageSender\Application\MessageSenderService;

class ContactService
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
     * @param UpsertCustomer $command
     *
     * @throws MessageSenderException
     */
    public function upsertCustomer(UpsertCustomer $command)
    {
        $configuration = $this->configurationReadModel->getConfigurationForShop($command->getShopId());

        if (false === $configuration->isContactLiveSynchronizationActive()) {
            return;
        }

        $customerAdapter = new CustomerAdapter();

        $this->messageSenderService->send(
            $configuration->getLiveSynchronizationUrl(),
            $customerAdapter->getCustomerById($command->getCustomerId())
        );
    }

    /**
     * @param UpsertSubscriber $command
     *
     * @throws MessageSenderException
     */
    public function upsertSubscriber(UpsertSubscriber $command)
    {
        $configuration = $this->configurationReadModel->getConfigurationForShop($command->getShopId());

        if (false === $configuration->isContactLiveSynchronizationActive()) {
            return;
        }

        $this->messageSenderService->send(
            $configuration->getLiveSynchronizationUrl(),
            new Subscriber($command->getEmail(), $command->isMarketingConsent(), $command->getName())
        );
    }
}
