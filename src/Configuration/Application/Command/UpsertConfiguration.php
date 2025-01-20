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

namespace GetResponse\Configuration\Application\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

class UpsertConfiguration
{
    /** @var int */
    private $shopId;
    /** @var string|null */
    private $facebookPixelSnippet;
    /** @var string|null */
    private $facebookAdsPixelSnippet;
    /** @var string|null */
    private $facebookBusinessExtensionSnippet;
    /** @var string|null */
    private $getResponseChatSnippet;
    /** @var string|null */
    private $getResponseRecommendationSnippet;
    /** @var string|null */
    private $getResponseWebTrackingSnippet;
    /** @var int|null */
    private $getResponseWebFormId;
    /** @var string|null */
    private $getResponseWebFormUrl;
    /** @var string|null */
    private $getResponseWebFormPosition;
    /** @var string|null */
    private $liveSynchronizationUrl;
    /** @var string|null */
    private $liveSynchronizationType;
    /** @var string|null */
    private $getResponseShopId;

    public function __construct(
        int $shopId,
        ?string $facebookPixelSnippet,
        ?string $facebookAdsPixelSnippet,
        ?string $facebookBusinessExtensionSnippet,
        ?string $getResponseChatSnippet,
        ?string $getResponseRecommendationSnippet,
        ?string $getResponseWebTrackingSnippet,
        ?int $getResponseWebFormId,
        ?string $getResponseWebFormUrl,
        ?string $getResponseWebFormPosition,
        ?string $liveSynchronizationUrl,
        ?string $liveSynchronizationType,
        ?string $getResponseShopId
    ) {
        $this->shopId = $shopId;
        $this->facebookPixelSnippet = $facebookPixelSnippet;
        $this->facebookAdsPixelSnippet = $facebookAdsPixelSnippet;
        $this->facebookBusinessExtensionSnippet = $facebookBusinessExtensionSnippet;
        $this->getResponseChatSnippet = $getResponseChatSnippet;
        $this->getResponseRecommendationSnippet = $getResponseRecommendationSnippet;
        $this->getResponseWebTrackingSnippet = $getResponseWebTrackingSnippet;
        $this->getResponseWebFormId = $getResponseWebFormId;
        $this->getResponseWebFormUrl = $getResponseWebFormUrl;
        $this->getResponseWebFormPosition = $getResponseWebFormPosition;
        $this->liveSynchronizationUrl = $liveSynchronizationUrl;
        $this->liveSynchronizationType = $liveSynchronizationType;
        $this->getResponseShopId = $getResponseShopId;
    }

    public function getShopId(): int
    {
        return $this->shopId;
    }

    /**
     * @return string|null
     */
    public function getFacebookPixelSnippet(): ?string
    {
        return $this->facebookPixelSnippet;
    }

    /**
     * @return string|null
     */
    public function getFacebookAdsPixelSnippet(): ?string
    {
        return $this->facebookAdsPixelSnippet;
    }

    /**
     * @return string|null
     */
    public function getFacebookBusinessExtensionSnippet(): ?string
    {
        return $this->facebookBusinessExtensionSnippet;
    }

    /**
     * @return string|null
     */
    public function getGetResponseChatSnippet(): ?string
    {
        return $this->getResponseChatSnippet;
    }

    /**
     * @return string|null
     */
    public function getGetResponseWebTrackingSnippet(): ?string
    {
        return $this->getResponseWebTrackingSnippet;
    }

    /**
     * @return int|null
     */
    public function getGetResponseWebFormId(): ?int
    {
        return $this->getResponseWebFormId;
    }

    /**
     * @return string|null
     */
    public function getGetResponseWebFormUrl(): ?string
    {
        return $this->getResponseWebFormUrl;
    }

    /**
     * @return string
     */
    public function getGetResponseWebFormPosition(): string
    {
        return (string) $this->getResponseWebFormPosition;
    }

    /**
     * @return string
     */
    public function getLiveSynchronizationUrl(): string
    {
        return (string) $this->liveSynchronizationUrl;
    }

    /**
     * @return string|null
     */
    public function getLiveSynchronizationType(): ?string
    {
        return $this->liveSynchronizationType;
    }

    /**
     * @return string|null
     */
    public function getGetResponseShopId(): ?string
    {
        return $this->getResponseShopId;
    }

    /**
     * @return string|null
     */
    public function getGetResponseRecommendationSnippet(): ?string
    {
        return $this->getResponseRecommendationSnippet;
    }
}
