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

namespace GetResponse\Configuration\Application;

use GetResponse\Configuration\Domain\Configuration;
use GetResponse\Configuration\Domain\ConfigurationRepository;
use GetResponse\Configuration\Domain\LiveSynchronization;
use GetResponse\Configuration\Domain\WebForm;

class ConfigurationService
{
    private $configurationRepository;

    /**
     * @param ConfigurationRepository $configurationRepository
     */
    public function __construct($configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function upsertConfiguration($configuration)
    {
        $this->configurationRepository->upsertConfiguration(
            new Configuration(
                $configuration->getShopId(),
                $configuration->getFacebookPixelSnippet(),
                $configuration->getFacebookAdsPixelSnippet(),
                $configuration->getFacebookBusinessExtensionSnippet(),
                $configuration->getGetResponseChatSnippet(),
                $configuration->getGetResponseRecommendationSnippet(),
                $configuration->getGetResponseWebTrackingSnippet(),
                $this->getWebForm($configuration),
                $this->getLiveSynchronization($configuration),
                $configuration->getGetResponseShopId()
            )
        );
    }

    /**
     * @param $updateConfiguration
     *
     * @return WebForm|null
     */
    private function getWebForm($updateConfiguration)
    {
        if (null !== $updateConfiguration->getGetResponseWebFormId()
            && null !== $updateConfiguration->getGetResponseWebFormUrl()
            && null !== $updateConfiguration->getGetResponseWebFormPosition()
        ) {
            return new WebForm(
                $updateConfiguration->getGetResponseWebFormId(),
                $updateConfiguration->getGetResponseWebFormUrl(),
                $updateConfiguration->getGetResponseWebFormPosition()
            );
        }

        return null;
    }

    /**
     * @param $updateConfiguration
     *
     * @return LiveSynchronization|null
     */
    private function getLiveSynchronization($configuration)
    {
        $type = $configuration->getLiveSynchronizationType();
        $url = $configuration->getLiveSynchronizationUrl();

        return null !== $type && null !== $url ? new LiveSynchronization($url, $type) : null;
    }

    public function deleteAllConfigurations()
    {
        $this->configurationRepository->deleteAllConfigurations();
    }
}
