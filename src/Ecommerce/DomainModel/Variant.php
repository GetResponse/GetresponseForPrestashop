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

class Variant implements \JsonSerializable
{
    /** @var int */
    private $id;
    /** @var int */
    private $productId;
    /** @var string */
    private $name;
    /** @var string */
    private $sku;
    /** @var float */
    private $price;
    /** @var float */
    private $priceTax;
    /** @var float|null */
    private $previousPrice;
    /** @var float|null */
    private $previousPriceTax;
    /** @var int */
    private $quantity;
    /** @var string */
    private $url;
    /** @var int|null */
    private $position;
    /** @var int|null */
    private $barcode;
    /** @var string */
    private $shortDescription;
    /** @var string */
    private $description;
    /** @var Image[]|null */
    private $images;
    /** @var string */
    private $status;

    /**
     * @param Image[]|null $images
     */
    public function __construct(
        int $id,
        int $productId,
        string $name,
        string $sku,
        float $price,
        float $priceTax,
        ?float $previousPrice,
        ?float $previousPriceTax,
        int $quantity,
        string $url,
        ?int $position,
        ?int $barcode,
        string $shortDescription,
        string $description,
        ?array $images,
        string $status
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->name = $name;
        $this->sku = $sku;
        $this->price = $price;
        $this->priceTax = $priceTax;
        $this->previousPrice = $previousPrice;
        $this->previousPriceTax = $previousPriceTax;
        $this->quantity = $quantity;
        $this->url = $url;
        $this->position = $position;
        $this->barcode = $barcode;
        $this->shortDescription = $shortDescription;
        $this->description = $description;
        $this->images = $images;
        $this->status = $status;
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
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getPriceTax(): float
    {
        return $this->priceTax;
    }

    /**
     * @return float|null
     */
    public function getPreviousPrice(): ?float
    {
        return $this->previousPrice;
    }

    /**
     * @return float|null
     */
    public function getPreviousPriceTax(): ?float
    {
        return $this->previousPriceTax;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @return int|null
     */
    public function getBarcode(): ?int
    {
        return $this->barcode;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @return Image[]|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $images = [];
        if ($this->images !== null) {
            foreach ($this->images as $image) {
                $images[] = $image->jsonSerialize();
            }
        }

        return [
            'id' => $this->id,
            'product_id' => $this->productId,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'price_tax' => $this->priceTax,
            'previous_price' => $this->previousPrice,
            'previous_price_tax' => $this->previousPriceTax,
            'quantity' => $this->quantity,
            'url' => $this->url,
            'position' => $this->position,
            'barcode' => $this->barcode,
            'short_description' => $this->shortDescription,
            'description' => $this->description,
            'images' => $images,
            'status' => $this->status,
        ];
    }
}
