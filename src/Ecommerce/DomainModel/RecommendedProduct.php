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

class RecommendedProduct
{
    /** @var string */
    private $url;
    /** @var int */
    private $externalId;
    /** @var string */
    private $name;
    /** @var float */
    private $price;
    /** @var string */
    private $imageUrl;
    /** @var string */
    private $description;
    /** @var array|string[] */
    private $categories;
    /** @var string */
    private $sku;
    /** @var float|null */
    private $previousPrice;

    /**
     * @param string $url
     * @param int $externalId
     * @param string $name
     * @param float $price
     * @param string $imageUrl
     * @param string $description
     * @param string[] $categories
     * @param string $sku
     * @param float|null $previousPrice
     */
    public function __construct(
        string $url,
        int $externalId,
        string $name,
        float $price,
        string $imageUrl,
        string $description,
        array $categories,
        string $sku,
        ?float $previousPrice
    ) {
        $this->url = $url;
        $this->externalId = $externalId;
        $this->name = $name;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->description = $description;
        $this->categories = $categories;
        $this->sku = $sku;
        $this->previousPrice = $previousPrice;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getExternalId(): int
    {
        return $this->externalId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDescriptionWithoutHtmlTags(): string
    {
        if (empty($this->description)) {
            return '';
        }
        $description = strlen($this->description) > 30000
            ? substr($this->description, 0, 30000 - 3) . '...'
            : $this->description;

        return str_replace(['\n', '\r'], '', strip_tags($description));
    }

    /**
     * @return array|string[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return float|null
     */
    public function getPreviousPrice(): ?float
    {
        return $this->previousPrice;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'productUrl' => $this->url,
            'pageUrl' => $this->url,
            'productExternalId' => $this->externalId,
            'productName' => $this->name,
            'price' => number_format($this->price, 2, '.', ''),
            'imageUrl' => $this->imageUrl,
            'description' => $this->getDescriptionWithoutHtmlTags(),
            'category' => implode(' > ', $this->categories),
            'available' => true,
            'sku' => $this->sku,
            'attribute1' => $this->previousPrice !== null ? number_format($this->previousPrice, 2, '.', '') : null,
            'attribute2' => null,
            'attribute3' => null,
            'attribute4' => null,
        ];
    }
}
