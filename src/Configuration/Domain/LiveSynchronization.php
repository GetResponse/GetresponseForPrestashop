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

namespace GetResponse\Configuration\Domain;

use InvalidArgumentException;

if (!defined('_PS_VERSION_')) {
    exit;
}

class LiveSynchronization
{
    /** @var string */
    private $url;
    /** @var string */
    private $type;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $url, string $type)
    {
        if (false === in_array($type, ['Contacts', 'Products', 'FullEcommerce'])) {
            throw new InvalidArgumentException(
                sprintf('Not valid type `%s`', $type)
            );
        }

        $this->url = $url;
        $this->type = $type;
    }

    public function __toString(): string
    {
        $data = [
            'url' => $this->url,
            'type' => $this->type,
        ];

        return json_encode($data) ?: '';
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
