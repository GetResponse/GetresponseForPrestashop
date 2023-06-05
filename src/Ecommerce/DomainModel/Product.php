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

use GetResponse\SharedKernel\CallbackType;
use JsonSerializable;

class Product implements JsonSerializable
{
    const CONFIGURABLE_TYPE = 'configurable';
    const SINGLE_TYPE = 'single';

    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $type;
    /** @var string */
    private $url;
    /** @var string */
    private $vendor;
    /** @var Category[] */
    private $categories;
    /** @var Variant[] */
    private $variants;
    /** @var string */
    private $createdAt;
    /** @var string|null */
    private $updatedAt;
    /** @var string */
    private $status;

    public function __construct(
        $id,
        $name,
        $type,
        $url,
        $vendor,
        $categories,
        $variants,
        $createdAt,
        $updatedAt,
        $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->url = $url;
        $this->vendor = $vendor;
        $this->categories = $categories;
        $this->variants = $variants;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getVariants()
    {
        return $this->variants;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $categories[] = $category->jsonSerialize();
        }

        $variants = [];
        foreach ($this->variants as $variant) {
            $variants[] = $variant->jsonSerialize();
        }

        return [
            'callback_type' => CallbackType::PRODUCT_UPDATE,
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'url' => $this->url,
            'vendor' => $this->vendor,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'categories' => $categories,
            'variants' => $variants,
            'status' => $variants
        ];
    }
}
