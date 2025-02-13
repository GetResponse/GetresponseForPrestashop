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
if (!defined('_PS_VERSION_')) {
    exit;
}

include_once _PS_MODULE_DIR_ . '/grprestashop/vendor/autoload.php';

use GetResponse\Configuration\Application\Command\UpsertConfiguration;
use GetResponse\Configuration\Application\ConfigurationService;
use GetResponse\Configuration\Infrastructure\ConfigurationRepository;
use GetResponse\Configuration\ReadModel\ConfigurationDto;
use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\Contact\Application\Command\UnsubscribeContact;
use GetResponse\Contact\Application\SubscriberService;
use GetResponse\Contact\Infrastructure\NewsletterDbRepository;

class WebserviceSpecificManagementGetresponseModule implements WebserviceSpecificManagementInterface
{
    /** @var WebserviceOutputBuilderCore */
    protected $objOutput;

    /** @var array<string, mixed> */
    protected $output;

    /** @var WebserviceRequestCore */
    protected $wsObject;

    /** @var array<string> */
    protected $urlSegment;

    /** @var array<string> */
    protected $errors = [];

    /** @var string */
    protected $content;

    /**
     * @param WebserviceOutputBuilderCore $obj
     *
     * @return WebserviceSpecificManagementInterface
     */
    public function setObjectOutput(WebserviceOutputBuilderCore $obj): WebserviceSpecificManagementInterface
    {
        $this->objOutput = $obj;

        return $this;
    }

    /**
     * @param WebserviceRequestCore $obj
     *
     * @return void
     */
    public function setWsObject(WebserviceRequestCore $obj): void
    {
        $this->wsObject = $obj;
    }

    /**
     * @return WebserviceRequestCore
     */
    public function getWsObject(): WebserviceRequestCore
    {
        return $this->wsObject;
    }

    /**
     * @return WebserviceOutputBuilderCore
     */
    public function getObjectOutput(): WebserviceOutputBuilderCore
    {
        return $this->objOutput;
    }

    /**
     * @param array<string> $segments
     *
     * @return void
     */
    public function setUrlSegment(array $segments): void
    {
        $this->urlSegment = $segments;
    }

    /**
     * @return array<string>
     */
    public function getUrlSegment(): array
    {
        return $this->urlSegment;
    }

    /**
     * @return bool
     */
    public function manage(): bool
    {
        switch ($this->wsObject->method) {
            case 'GET':
                $this->content = $this->getPluginDetails();
                break;
            case 'POST':
                $this->updateSettings();
                break;
            case 'PUT':
                if ($this->isUnsubscribeContactPath()) {
                    $this->unsubscribeContact();
                }
                break;
        }

        return $this->wsObject->getOutputEnabled();
    }

    /**
     * @return void
     */
    private function updateSettings(): void
    {
        $payload = $this->getPayload();

        $idShop = isset($payload['shop_id']) ? (int) $payload['shop_id'] : null;
        $settings = isset($payload['settings']) ? $payload['settings'] : null;

        if (null === $idShop || !is_array($settings)) {
            return;
        }

        $configurationService = new ConfigurationService(new ConfigurationRepository());
        $configurationService->upsertConfiguration(
            new UpsertConfiguration(
                $idShop,
                isset($settings['facebook_pixel_snippet']) ? (string) $settings['facebook_pixel_snippet'] : null,
                isset($settings['facebook_ads_pixel_snippet']) ? (string) $settings['facebook_ads_pixel_snippet'] : null,
                isset($settings['facebook_business_pixel_snippet']) ? (string) $settings['facebook_business_pixel_snippet'] : null,
                isset($settings['getresponse_chat_snippet']) ? (string) $settings['getresponse_chat_snippet'] : null,
                isset($settings['getresponse_recommendation_snippet']) ? (string) $settings['getresponse_recommendation_snippet'] : null,
                isset($settings['getresponse_web_tracking_snippet']) ? (string) $settings['getresponse_web_tracking_snippet'] : null,
                isset($settings['getresponse_web_form_id']) ? (int) $settings['getresponse_web_form_id'] : null,
                isset($settings['getresponse_web_form_url']) ? (string) $settings['getresponse_web_form_url'] : null,
                isset($settings['getresponse_web_form_position']) ? (string) $settings['getresponse_web_form_position'] : null,
                isset($settings['live_synchronization_url']) ? (string) $settings['live_synchronization_url'] : null,
                isset($settings['live_synchronization_type']) ? (string) $settings['live_synchronization_type'] : null,
                isset($settings['getresponse_shop_id']) ? (string) $settings['getresponse_shop_id'] : null
            )
        );
    }

    /**
     * @return array<string>
     */
    public function getContent(): array
    {
        return [
            'content' => $this->content,
        ];
    }

    /**
     * @return void
     */
    private function unsubscribeContact(): void
    {
        $payload = $this->getPayload();

        $shopId = isset($payload['shop_id']) ? (int) $payload['shop_id'] : null;
        $email = isset($payload['email']) ? (string) $payload['email'] : null;

        if (null === $shopId || empty($email)) {
            return;
        }

        $subscriberService = new SubscriberService(
            new NewsletterDbRepository()
        );
        $subscriberService->unsubscribe(
            new UnsubscribeContact($shopId, $email)
        );
    }

    /**
     * @return string
     */
    private function getPluginDetails(): string
    {
        $shops = [];
        $configurationReadModel = new ConfigurationReadModel(new ConfigurationRepository());
        $configurations = $configurationReadModel->getConfigurationForAllShops();

        /** @var ConfigurationDto $configuration */
        foreach ($configurations as $configuration) {
            $shops[$configuration->getShopId()] = [
                'facebook_pixel_snippet' => $configuration->getFacebookPixelSnippet(),
                'facebook_ads_pixel_snippet' => $configuration->getFacebookAdsPixelSnippet(),
                'facebook_business_pixel_snippet' => $configuration->getFacebookBusinessExtensionSnippet(),
                'getresponse_chat_snippet' => $configuration->getGetResponseChatSnippet(),
                'getresponse_recommendation_snippet' => $configuration->getGetResponseRecommendationSnippet(),
                'getresponse_web_tracking_snippet' => $configuration->getGetResponseWebTrackingSnippet(),
                'getresponse_web_form_id' => $configuration->getGetResponseWebFormId(),
                'getresponse_web_form_url' => $configuration->getGetResponseWebFormUrl(),
                'getresponse_web_form_position' => $configuration->getGetResponseWebFormPosition(),
                'live_synchronization_url' => $configuration->getLiveSynchronizationUrl(),
                'live_synchronization_type' => $configuration->getLiveSynchronizationType(),
                'getresponse_shop_id' => $configuration->getGetresponseShopId(),
            ];
        }

        $this->objOutput->setHeaderParams('Content-Type', (new WebserviceOutputJSON())->getContentType());

        return json_encode(
            [
                'plugin_version' => '1.5.0',
                'prestashop_version' => _PS_VERSION_,
                'php_version' => phpversion(),
                'shops' => $shops,
            ]
        ) ?: '';
    }

    /**
     * @return bool
     */
    private function isUnsubscribeContactPath(): bool
    {
        return isset($this->wsObject->urlSegment[1], $this->wsObject->urlSegment[2])
            && $this->wsObject->urlSegment[1] === 'contact'
            && $this->wsObject->urlSegment[2] === 'unsubscribe';
    }

    /**
     * @return array<string>
     */
    private function getPayload(): array
    {
        $json = Tools::file_get_contents('php://input');
        $data = is_string($json) ? json_decode($json, true) : [];

        return is_array($data) ? array_map('strval', $data) : [];
    }
}
