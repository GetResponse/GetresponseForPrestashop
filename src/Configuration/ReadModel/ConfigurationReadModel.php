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

namespace GetResponse\Configuration\ReadModel;

use GetResponse\Configuration\Infrastructure\ConfigurationRepository;
use Shop;

class ConfigurationReadModel
{
    /** @var ConfigurationRepository */
    private $repository;

    /**
     * @param ConfigurationRepository $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ConfigurationDtoCollection
     */
    public function getConfigurationForAllShops()
    {
        $collection = new ConfigurationDtoCollection();

        foreach (Shop::getShops() as $shop) {
            $collection->add($this->repository->getConfigurationForShop((int) $shop['id_shop']));
        }

        return $collection;
    }

    /**
     * @param int $shopId
     *
     * @return ConfigurationDto
     */
    public function getConfigurationForShop($shopId)
    {
        return $this->repository->getConfigurationForShop($shopId);
    }
}
