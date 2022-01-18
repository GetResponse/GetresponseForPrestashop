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

use Configuration as PrestaShopConfiguration;
use GetResponse\Configuration\Domain\Configuration;
use GetResponse\Configuration\Domain\ConfigurationRepository as Repository;
use GetResponse\Configuration\ReadModel\ConfigurationDto;
use Shop;

class ConfigurationRepository implements Repository
{
    const FB_PIXEL_SNIPPET = 'GR_CONFIG_FB_PIXEL_SNIPPET';
    const FB_ADS_PIXEL_SNIPPET = 'GR_CONFIG_FB_ADS_PIXEL_SNIPPET';
    const FB_BUSINESS_EXT_SNIPPET = 'GR_CONFIG_FB_BE_SNIPPET';
    const GR_CHAT_SNIPPET = 'GR_CONFIG_GR_CHAT_SNIPPET';
    const GR_TRACKING_SNIPPET = 'GR_CONFIG_GR_TRACKING_SNIPPET';
    const GR_FORM = 'GR_CONFIG_GR_FORM';
    const GR_LIVE_SYNC = 'GR_CONFIG_GR_LIVE_SYNC';

    /**
     * @param Configuration $configuration
     */
    public function upsertConfiguration($configuration)
    {
        Shop::setContext(Shop::CONTEXT_SHOP, $configuration->getShopId());

        $this->updateConfig(self::FB_PIXEL_SNIPPET, $configuration->getFacebookPixelSnippet());
        $this->updateConfig(self::FB_ADS_PIXEL_SNIPPET, $configuration->getFacebookAdsPixelSnippet());
        $this->updateConfig(self::FB_BUSINESS_EXT_SNIPPET, $configuration->getFacebookBusinessExtensionSnippet());
        $this->updateConfig(self::GR_CHAT_SNIPPET, $configuration->getGetResponseChatSnippet());
        $this->updateConfig(self::GR_TRACKING_SNIPPET, $configuration->getGetResponseWebTrackingSnippet());
        $this->updateConfig(self::GR_FORM, $configuration->getGetResponseWebForm());
        $this->updateConfig(self::GR_LIVE_SYNC, $configuration->getLiveSynchronization());
    }

    public function deleteAllConfigurations()
    {
        PrestaShopConfiguration::deleteByName(self::FB_PIXEL_SNIPPET);
        PrestaShopConfiguration::deleteByName(self::FB_ADS_PIXEL_SNIPPET);
        PrestaShopConfiguration::deleteByName(self::FB_BUSINESS_EXT_SNIPPET);
        PrestaShopConfiguration::deleteByName(self::GR_CHAT_SNIPPET);
        PrestaShopConfiguration::deleteByName(self::GR_TRACKING_SNIPPET);
        PrestaShopConfiguration::deleteByName(self::GR_FORM);
        PrestaShopConfiguration::deleteByName(self::GR_LIVE_SYNC);
    }

    private function updateConfig(string $key, $value)
    {
        $value = is_object($value) ? (string) $value : $value;

        $keyWithPrefix = $key;
        PrestaShopConfiguration::updateValue($keyWithPrefix, $value);
    }

    public function getConfigurationForShop($shopId)
    {
        Shop::setContext(Shop::CONTEXT_SHOP, $shopId);

        $getResponseWebFormId = null;
        $getResponseWebFormUrl = null;
        $getResponseWebFormBlock = null;
        $getResponseWebForm = PrestaShopConfiguration::get(self::GR_FORM);
        if (!empty($getResponseWebForm)) {
            $webForm = json_decode($getResponseWebForm, true);
            $getResponseWebFormId = $webForm['id'];
            $getResponseWebFormUrl = $webForm['url'];
            $getResponseWebFormBlock = $webForm['position'];
        }

        $getResponseLiveSyncType = null;
        $getResponseLiveSyncUrl = null;
        $getResponseLiveSync = PrestaShopConfiguration::get(self::GR_LIVE_SYNC);
        if (!empty($getResponseLiveSync)) {
            $liveSync = json_decode($getResponseLiveSync, true);
            $getResponseLiveSyncType = $liveSync['type'];
            $getResponseLiveSyncUrl = $liveSync['url'];
        }

        return new ConfigurationDto(
            $shopId,
            PrestaShopConfiguration::get(self::FB_PIXEL_SNIPPET) ?: null,
            PrestaShopConfiguration::get(self::FB_ADS_PIXEL_SNIPPET) ?: null,
            PrestaShopConfiguration::get(self::FB_BUSINESS_EXT_SNIPPET) ?: null,
            PrestaShopConfiguration::get(self::GR_CHAT_SNIPPET) ?: null,
            PrestaShopConfiguration::get(self::GR_TRACKING_SNIPPET) ?: null,
            $getResponseWebFormId,
            $getResponseWebFormUrl,
            $getResponseWebFormBlock,
            $getResponseLiveSyncUrl,
            $getResponseLiveSyncType
        );
    }
}
