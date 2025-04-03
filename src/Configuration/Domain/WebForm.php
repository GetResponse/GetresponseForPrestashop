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

use Assert\Assertion;
use GetResponse\Configuration\SharedKernel\WebFormPosition;

if (!defined('_PS_VERSION_')) {
    exit;
}

class WebForm
{
    /** @var string */
    private $id;
    /** @var string */
    private $url;
    /** @var string */
    private $position;

    public function __construct(string $id, string $url, string $position)
    {
        $availablePositions = [
            WebFormPosition::FOOTER,
            WebFormPosition::HOME,
            WebFormPosition::BOTTOM,
            WebFormPosition::TOP,
            WebFormPosition::LEFT,
            WebFormPosition::RIGHT,
        ];
        Assertion::inArray($position, $availablePositions);
        $this->id = $id;
        $this->url = $url;
        $this->position = $position;
    }

    public function __toString(): string
    {
        $data = [
            'id' => $this->id,
            'url' => $this->url,
            'position' => $this->position,
        ];

        return json_encode($data) ?: '';
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }
}
