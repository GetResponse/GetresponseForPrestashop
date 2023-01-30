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

    /**
     * @param int $shopId
     * @param string|null $facebookPixelSnippet
     * @param string|null $facebookAdsPixelSnippet
     * @param string|null $facebookBusinessExtensionSnippet
     * @param string|null $getResponseChatSnippet
     * @param string|null $getResponseWebTrackingSnippet
     * @param int|null $getResponseWebFormId
     * @param string|null $getResponseWebFormUrl
     * @param string|null $getResponseWebFormPosition
     * @param string|null $liveSynchronizationUrl
     * @param string|null $liveSynchronizationType
     * @param string|null $getResponseShopId
     */
    public function __construct(
        $shopId,
        $facebookPixelSnippet,
        $facebookAdsPixelSnippet,
        $facebookBusinessExtensionSnippet,
        $getResponseChatSnippet,
        $getResponseWebTrackingSnippet,
        $getResponseWebFormId,
        $getResponseWebFormUrl,
        $getResponseWebFormPosition,
        $liveSynchronizationUrl,
        $liveSynchronizationType,
        $getResponseShopId
    ) {
        $this->shopId = $shopId;
        $this->facebookPixelSnippet = $facebookPixelSnippet;
        $this->facebookAdsPixelSnippet = $facebookAdsPixelSnippet;
        $this->facebookBusinessExtensionSnippet = $facebookBusinessExtensionSnippet;
        $this->getResponseChatSnippet = $getResponseChatSnippet;
        $this->getResponseWebTrackingSnippet = $getResponseWebTrackingSnippet;
        $this->getResponseWebFormId = $getResponseWebFormId;
        $this->getResponseWebFormUrl = $getResponseWebFormUrl;
        $this->getResponseWebFormPosition = $getResponseWebFormPosition;
        $this->liveSynchronizationUrl = $liveSynchronizationUrl;
        $this->liveSynchronizationType = $liveSynchronizationType;
        $this->getResponseShopId = $getResponseShopId;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @return string|null
     */
    public function getFacebookPixelSnippet()
    {
        return $this->facebookPixelSnippet;
    }

    /**
     * @return string|null
     */
    public function getFacebookAdsPixelSnippet()
    {
        return $this->facebookAdsPixelSnippet;
    }

    /**
     * @return string|null
     */
    public function getFacebookBusinessExtensionSnippet()
    {
        return $this->facebookBusinessExtensionSnippet;
    }

    /**
     * @return string|null
     */
    public function getGetResponseChatSnippet()
    {
        return $this->getResponseChatSnippet;
    }

    /**
     * @return string|null
     */
    public function getGetResponseWebTrackingSnippet()
    {
        return $this->getResponseWebTrackingSnippet;
    }

    /**
     * @return int|null
     */
    public function getGetResponseWebFormId()
    {
        return $this->getResponseWebFormId;
    }

    /**
     * @return string|null
     */
    public function getGetResponseWebFormUrl()
    {
        return $this->getResponseWebFormUrl;
    }

    /**
     * @return string|null
     */
    public function getGetResponseWebFormPosition()
    {
        return $this->getResponseWebFormPosition;
    }

    /**
     * @return string|null
     */
    public function getLiveSynchronizationUrl()
    {
        return $this->liveSynchronizationUrl;
    }

    /**
     * @return string|null
     */
    public function getLiveSynchronizationType()
    {
        return $this->liveSynchronizationType;
    }

    public function getGetResponseShopId()
    {
        return $this->getResponseShopId;
    }
}
