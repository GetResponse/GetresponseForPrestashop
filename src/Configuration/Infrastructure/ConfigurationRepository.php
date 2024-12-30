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

namespace GetResponse\Configuration\Infrastructure;

use GetResponse\Configuration\Application\Command\UpsertConfiguration;
use GetResponse\Configuration\Domain\Configuration;
use GetResponse\Configuration\Domain\ConfigurationRepository as Repository;
use GetResponse\Configuration\ReadModel\ConfigurationDto;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ConfigurationRepository implements Repository
{
    const FB_PIXEL_SNIPPET = 'GR_CONFIG_FB_PIXEL_SNIPPET';
    const FB_ADS_PIXEL_SNIPPET = 'GR_CONFIG_FB_ADS_PIXEL_SNIPPET';
    const FB_BUSINESS_EXT_SNIPPET = 'GR_CONFIG_FB_BE_SNIPPET';
    const GR_CHAT_SNIPPET = 'GR_CONFIG_GR_CHAT_SNIPPET';
    const GR_RECOMMENDATION_SNIPPET = 'GR_CONFIG_GR_RECOMMENDATION_SNIPPET';
    const GR_TRACKING_SNIPPET = 'GR_CONFIG_GR_TRACKING_SNIPPET';
    const GR_FORM = 'GR_CONFIG_GR_FORM';
    const GR_LIVE_SYNC = 'GR_CONFIG_GR_LIVE_SYNC';
    const GR_SHOP_ID = 'GR_CONFIG_GR_SHOP_ID';

    /**
     * @param Configuration|UpsertConfiguration $configuration
     */
    public function upsertConfiguration($configuration)
    {
        \Shop::setContext(\Shop::CONTEXT_SHOP, $configuration->getShopId());

        $this->updateConfig(self::FB_PIXEL_SNIPPET, $configuration->getFacebookPixelSnippet());
        $this->updateConfig(self::FB_ADS_PIXEL_SNIPPET, $configuration->getFacebookAdsPixelSnippet());
        $this->updateConfig(self::FB_BUSINESS_EXT_SNIPPET, $configuration->getFacebookBusinessExtensionSnippet());
        $this->updateConfig(self::GR_CHAT_SNIPPET, $configuration->getGetResponseChatSnippet());
        $this->updateConfig(self::GR_RECOMMENDATION_SNIPPET, $configuration->getGetResponseRecommendationSnippet());
        $this->updateConfig(self::GR_TRACKING_SNIPPET, $configuration->getGetResponseWebTrackingSnippet());
        $this->updateConfig(self::GR_FORM, $configuration->getGetResponseWebForm());
        $this->updateConfig(self::GR_LIVE_SYNC, $configuration->getLiveSynchronization());
        $this->updateConfig(self::GR_SHOP_ID, $configuration->getGetresponseShopId());
    }

    public function deleteAllConfigurations()
    {
        \Configuration::deleteByName(self::FB_PIXEL_SNIPPET);
        \Configuration::deleteByName(self::FB_ADS_PIXEL_SNIPPET);
        \Configuration::deleteByName(self::FB_BUSINESS_EXT_SNIPPET);
        \Configuration::deleteByName(self::GR_CHAT_SNIPPET);
        \Configuration::deleteByName(self::GR_RECOMMENDATION_SNIPPET);
        \Configuration::deleteByName(self::GR_TRACKING_SNIPPET);
        \Configuration::deleteByName(self::GR_FORM);
        \Configuration::deleteByName(self::GR_LIVE_SYNC);
        \Configuration::deleteByName(self::GR_SHOP_ID);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    private function updateConfig(string $key, $value): void
    {
        $value = is_object($value) ? (string) $value : $value;

        $keyWithPrefix = $key;
        \Configuration::updateValue($keyWithPrefix, $value);
    }

    /**
     * @param int $shopId
     *
     * @return ConfigurationDto
     */
    public function getConfigurationForShop(int $shopId): ConfigurationDto
    {
        \Shop::setContext(\Shop::CONTEXT_SHOP, $shopId);

        $getResponseWebFormId = null;
        $getResponseWebFormUrl = null;
        $getResponseWebFormBlock = null;
        $getResponseWebForm = \Configuration::get(self::GR_FORM);
        if (!empty($getResponseWebForm)) {
            $webForm = json_decode($getResponseWebForm, true);
            $getResponseWebFormId = $webForm['id'];
            $getResponseWebFormUrl = $webForm['url'];
            $getResponseWebFormBlock = $webForm['position'];
        }

        $getResponseLiveSyncType = null;
        $getResponseLiveSyncUrl = null;
        $getResponseLiveSync = \Configuration::get(self::GR_LIVE_SYNC);
        if (!empty($getResponseLiveSync)) {
            $liveSync = json_decode($getResponseLiveSync, true);
            $getResponseLiveSyncType = $liveSync['type'];
            $getResponseLiveSyncUrl = $liveSync['url'];
        }

        return new ConfigurationDto(
            $shopId,
            \Configuration::get(self::FB_PIXEL_SNIPPET) ?: null,
            \Configuration::get(self::FB_ADS_PIXEL_SNIPPET) ?: null,
            \Configuration::get(self::FB_BUSINESS_EXT_SNIPPET) ?: null,
            \Configuration::get(self::GR_CHAT_SNIPPET) ?: null,
            \Configuration::get(self::GR_RECOMMENDATION_SNIPPET) ?: null,
            \Configuration::get(self::GR_TRACKING_SNIPPET) ?: null,
            $getResponseWebFormId,
            $getResponseWebFormUrl,
            $getResponseWebFormBlock,
            $getResponseLiveSyncUrl,
            $getResponseLiveSyncType,
            \Configuration::get(self::GR_SHOP_ID) ?: null
        );
    }
}
