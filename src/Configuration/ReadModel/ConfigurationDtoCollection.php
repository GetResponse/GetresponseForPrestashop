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

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @template T
 * @implements \IteratorAggregate<int, T>
 */
class ConfigurationDtoCollection implements \IteratorAggregate
{
    /** @var array<int, T> */
    private $configurations = [];

    /**
     * @param T $configuration
     *
     * @return void
     */
    public function add($configuration): void
    {
        $this->configurations[] = $configuration;
    }

    /**
     * @return \ArrayIterator<int, T>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->configurations);
    }
}
