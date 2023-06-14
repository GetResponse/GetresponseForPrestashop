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

class Configuration
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
    /** @var WebForm|null */
    private $getResponseWebForm;
    /** @var LiveSynchronization|null */
    private $liveSynchronization;
    /** @var string|null */
    private $getresponseShopId;

    public function __construct(
        $shopId,
        $facebookPixelSnippet,
        $facebookAdsPixelSnippet,
        $facebookBusinessExtensionSnippet,
        $getResponseChatSnippet,
        $getResponseRecommendationSnippet,
        $getResponseWebTrackingSnippet,
        $getResponseWebForm,
        $liveSynchronization,
        $getresponseShopId
    ) {
        $this->shopId = $shopId;
        $this->facebookPixelSnippet = $facebookPixelSnippet;
        $this->facebookAdsPixelSnippet = $facebookAdsPixelSnippet;
        $this->facebookBusinessExtensionSnippet = $facebookBusinessExtensionSnippet;
        $this->getResponseChatSnippet = $getResponseChatSnippet;
        $this->getResponseRecommendationSnippet = $getResponseRecommendationSnippet;
        $this->getResponseWebTrackingSnippet = $getResponseWebTrackingSnippet;
        $this->getResponseWebForm = $getResponseWebForm;
        $this->liveSynchronization = $liveSynchronization;
        $this->getresponseShopId = $getresponseShopId;
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
     * @return WebForm|null
     */
    public function getGetResponseWebForm()
    {
        return $this->getResponseWebForm;
    }

    /**
     * @return LiveSynchronization|null
     */
    public function getLiveSynchronization()
    {
        return $this->liveSynchronization;
    }

    /**
     * @return string|null
     */
    public function getGetresponseShopId()
    {
        return $this->getresponseShopId;
    }

    /**
     * @return string|null
     */
    public function getGetResponseRecommendationSnippet()
    {
        return $this->getResponseRecommendationSnippet;
    }
}
