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
    protected $output;
    /** @var WebserviceRequest */
    protected $wsObject;
    protected $urlSegment;
    protected $errors = [];
    protected $content;

    /**
     * @param WebserviceOutputBuilderCore $obj
     *
     * @return WebserviceSpecificManagementInterface
     */
    public function setObjectOutput(WebserviceOutputBuilderCore $obj)
    {
        $this->objOutput = $obj;

        return $this;
    }

    public function setWsObject(WebserviceRequestCore $obj)
    {
        $this->wsObject = $obj;

        return $this;
    }

    public function getWsObject()
    {
        return $this->wsObject;
    }

    public function getObjectOutput()
    {
        return $this->objOutput;
    }

    public function setUrlSegment($segments)
    {
        $this->urlSegment = $segments;

        return $this;
    }

    public function getUrlSegment()
    {
        return $this->urlSegment;
    }

    public function manage()
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

    private function updateSettings()
    {
        $payload = $this->wsObject->getPayload();
        $idShop = empty($payload['shop_id']) ? null : (int) $payload['shop_id'];
        $settings = empty($payload['settings']) ? null : $payload['settings'];

        if (null === $idShop || empty($settings)) {
            return;
        }

        $configurationService = new ConfigurationService(new ConfigurationRepository());
        $configurationService->upsertConfiguration(
            new UpsertConfiguration(
                $idShop,
                !empty($settings['facebook_pixel_snippet']) ? $settings['facebook_pixel_snippet'] : null,
                !empty($settings['facebook_ads_pixel_snippet']) ? $settings['facebook_ads_pixel_snippet'] : null,
                !empty($settings['facebook_business_pixel_snippet']) ? $settings['facebook_business_pixel_snippet'] : null,
                !empty($settings['getresponse_chat_snippet']) ? $settings['getresponse_chat_snippet'] : null,
                !empty($settings['getresponse_web_tracking_snippet']) ? $settings['getresponse_web_tracking_snippet'] : null,
                !empty($settings['getresponse_web_form_id']) ? $settings['getresponse_web_form_id'] : null,
                !empty($settings['getresponse_web_form_url']) ? $settings['getresponse_web_form_url'] : null,
                !empty($settings['getresponse_web_form_position']) ? $settings['getresponse_web_form_position'] : null,
                !empty($settings['live_synchronization_url']) ? $settings['live_synchronization_url'] : null,
                !empty($settings['live_synchronization_type']) ? $settings['live_synchronization_type'] : null
            )
        );
    }

    public function getContent()
    {
        return $this->content;
    }

    private function unsubscribeContact()
    {
        $payload = $this->wsObject->getPayload();

        $shopId = empty($payload['shop_id']) ? null : (int) $payload['shop_id'];
        $email = empty($payload['email']) ? null : $payload['email'];

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

    private function getPluginDetails()
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
                'getresponse_web_tracking_snippet' => $configuration->getGetResponseWebTrackingSnippet(),
                'getresponse_web_form_id' => $configuration->getGetResponseWebFormId(),
                'getresponse_web_form_url' => $configuration->getGetResponseWebFormUrl(),
                'getresponse_web_form_position' => $configuration->getGetResponseWebFormPosition(),
                'live_synchronization_url' => $configuration->getLiveSynchronizationUrl(),
                'live_synchronization_type' => $configuration->getLiveSynchronizationType(),
            ];
        }

        $this->objOutput->setHeaderParams('Content-Type', (new WebserviceOutputJSON())->getContentType());

        return json_encode(
            [
                'plugin_version' => '1.0.3',
                'prestashop_version' => _PS_VERSION_,
                'php_version' => phpversion(),
                'shops' => $shops,
            ]
        );
    }

    private function isUnsubscribeContactPath()
    {
        return isset($this->wsObject->urlSegment[1], $this->wsObject->urlSegment[2])
            && $this->wsObject->urlSegment[1] === 'contact'
            && $this->wsObject->urlSegment[2] === 'unsubscribe';
    }
}
