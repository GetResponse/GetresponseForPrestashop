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

namespace GetResponse\Ecommerce\DomainModel;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Category implements \JsonSerializable
{
    /** @var int */
    private $id;
    /** @var int */
    private $parentId;
    /** @var string */
    private $name;
    /** @var bool */
    private $isDefault;
    /** @var ?string */
    private $url;

    public function __construct(
        int $id,
        int $parentId,
        string $name,
        bool $isDefault = false,
        ?string $url = null
    ) {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->isDefault = $isDefault;
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parentId,
            'name' => $this->name,
            'is_default' => $this->isDefault,
            'url' => $this->url,
        ];
    }
}
