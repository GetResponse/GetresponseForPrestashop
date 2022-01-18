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

    /**
     * @param $updateConfiguration
     */
    public function upsertConfiguration($updateConfiguration)
    {
        $this->configurationRepository->upsertConfiguration(
            new Configuration(
                $updateConfiguration->getShopId(),
                $updateConfiguration->getFacebookPixelSnippet(),
                $updateConfiguration->getFacebookAdsPixelSnippet(),
                $updateConfiguration->getFacebookBusinessExtensionSnippet(),
                $updateConfiguration->getGetResponseChatSnippet(),
                $updateConfiguration->getGetResponseWebTrackingSnippet(),
                $this->getWebForm($updateConfiguration),
                $this->getLiveSynchronization($updateConfiguration)
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
    private function getLiveSynchronization($updateConfiguration)
    {
        if (null !== $updateConfiguration->getLiveSynchronizationType() &&
            null !== $updateConfiguration->getLiveSynchronizationUrl()) {
            return new LiveSynchronization(
                $updateConfiguration->getLiveSynchronizationUrl(),
                $updateConfiguration->getLiveSynchronizationType()
            );
        }

        return null;
    }

    public function deleteAllConfigurations()
    {
        $this->configurationRepository->deleteAllConfigurations();
    }
}
