<?php
/**
 * This module integrate GetResponse and PrestaShop Allows subscribe via checkout page and export your contacts.
 *
 * @author Getresponse <grintegrations@getresponse.com>
 * @copyright GetResponse
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

include_once _PS_MODULE_DIR_ . '/getresponse/vendor/autoload.php';
include_once _PS_MODULE_DIR_ . '/getresponse/classes/WebserviceSpecificManagementGetresponseModule.php';

class Getresponse extends Module
{
    private $usedHooks = [
        'leftColumn',
        'rightColumn',
        'header',
        'footer',
        'top',
        'home',
        'addWebserviceResources',
        'displayBackOfficeHeader',
        'actionCustomerAccountAdd',
        'actionObjectCustomerUpdateBefore',
        'actionProductAdd',
        'actionProductUpdate',
        'actionObjectCustomerUpdateAfter',
        'cart',
        'actionOrderEdited',
        'newOrder',
        'actionOrderStatusPostUpdate',
        'actionNewsletterRegistrationAfter',
        'actionObjectAddressUpdateAfter',
        'actionObjectAddressAddAfter',
    ];

    public function __construct()
    {
        $this->name = 'getresponse';
        $this->tab = 'emailing';
        $this->version = '1.0.2';
        $this->author = 'GetResponse';
        $this->need_instance = 0;
        $this->module_key = 'b2dff089f1c2740a0ea180a1008fce6c';
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->displayName = $this->l('GetResponse');
        $this->description = 'Add your Prestashop contacts to GetResponse. Automatically follow-up new subscriptions ';
        $this->description .= 'with engaging email marketing campaigns';
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->bootstrap = true;

        parent::__construct();

        if (!function_exists('curl_init')) {
            $this->context->smarty->assign([
                'flash_message' => [
                    'message' => $this->l('Curl library not found'),
                    'status' => 'danger',
                ],
            ]);
        }
    }

    public function hookAddWebserviceResources()
    {
        return [
            'getresponse_module' => [
                'description' => 'Getresponse Integration',
                'specific_management' => true,
                'resources' => [
                    'getresponse_settings' => [
                        'description' => 'GetResponse Settings',
                        'class' => 'GetResponseSettingsCore',
                    ],
                ],
            ],
        ];
    }

    public function hookDisplayHome()
    {
        $currentShopId = $this->context->shop->id;
        $configurationReadModel = new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );
        $configuration = $configurationReadModel->getConfigurationForShop($currentShopId);

        return $this->getGrWebFormSnippet(
            $configuration,
            \GetResponse\Configuration\SharedKernel\WebFormPosition::HOME
        );
    }

    public function hookDisplayTop()
    {
        $currentShopId = $this->context->shop->id;
        $configurationReadModel = new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );
        $configuration = $configurationReadModel->getConfigurationForShop($currentShopId);

        return $this->getGrWebFormSnippet($configuration, \GetResponse\Configuration\SharedKernel\WebFormPosition::TOP);
    }

    public function hookDisplayLeftColumn()
    {
        $currentShopId = $this->context->shop->id;
        $configurationReadModel = new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );
        $configuration = $configurationReadModel->getConfigurationForShop($currentShopId);

        return $this->getGrWebFormSnippet($configuration, \GetResponse\Configuration\SharedKernel\WebFormPosition::LEFT);
    }

    public function hookDisplayRightColumn()
    {
        $currentShopId = $this->context->shop->id;
        $configurationReadModel = new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );
        $configuration = $configurationReadModel->getConfigurationForShop($currentShopId);

        return $this->getGrWebFormSnippet($configuration, \GetResponse\Configuration\SharedKernel\WebFormPosition::RIGHT);
    }

    public function hookDisplayFooter()
    {
        $currentShopId = $this->context->shop->id;
        $configurationReadModel = new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );
        $configuration = $configurationReadModel->getConfigurationForShop($currentShopId);

        $html = "<!-- getresponse start -->\n";
        $html .= $this->renderSnippet($configuration->getFacebookPixelSnippet());
        $html .= $this->renderSnippet($configuration->getFacebookAdsPixelSnippet());
        $html .= $this->renderSnippet($configuration->getFacebookBusinessExtensionSnippet());
        $html .= $this->renderSnippet($configuration->getGetResponseChatSnippet());
        $html .= $this->getGrWebFormSnippet(
            $configuration,
            \GetResponse\Configuration\SharedKernel\WebFormPosition::FOOTER
        );
        $html .= $this->getWebTrackingCustomerEmailSnippet($configuration);
        $html .= '<!-- getresponse end -->';

        return $html;
    }

    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCss($this->_path . 'views/css/tab.css');
    }

    /**
     * @return string
     */
    public function hookDisplayHeader()
    {
        $currentShopId = $this->context->shop->id;
        $configurationReadModel = new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );
        $configuration = $configurationReadModel->getConfigurationForShop($currentShopId);

        return $this->renderSnippet($configuration->getGetResponseWebTrackingSnippet());
    }

    /**
     * @throws PrestaShopException
     */
    public function getContent()
    {
        $configurationReadModel = new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );

        $shops = Shop::getShops();

        $viewData = [];

        foreach ($shops as $shop) {
            $configuration = $configurationReadModel->getConfigurationForShop($shop['id_shop']);

            $viewData['getresponse_settings'][$shop['name']] = [
                'fb_pixel' => !empty($configuration->getFacebookPixelSnippet()),
                'fb_ads_pixel' => !empty($configuration->getFacebookAdsPixelSnippet()),
                'fbe' => !empty($configuration->getFacebookBusinessExtensionSnippet()),
                'gr_tracking' => !empty($configuration->getGetResponseWebTrackingSnippet()),
                'web_form' => $configuration->hasWebForm(),
                'live_synchronization' => $configuration->hasLiveSynchronization(),
            ];
        }

        $this->smarty->assign($viewData);

        return $this->display(__FILE__, 'views/templates/admin/main.tpl');
    }

    /**
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function install()
    {
        if (!parent::install() || !$this->installTab()) {
            return false;
        }

        foreach ($this->usedHooks as $hook) {
            if (!$this->registerHook($hook)) {
                return false;
            }
        }

        // Update Version Number
        if (!Configuration::updateValue('GR_VERSION', $this->version)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function installTab()
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminGetresponse';
        $tab->name = [];
        $tab->id_parent = strpos(_PS_VERSION_, '1.6') === 0 ? 0 : (int) Tab::getIdFromClassName('AdminAdmin');
        $tab->module = $this->name;
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'GetResponse';
            $tab->icon = 'track_changes';
        }
        $tab->add();

        return true;
    }

    /**
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function uninstall()
    {
        if (!parent::uninstall() || !$this->uninstallTab()) {
            return false;
        }

        foreach ($this->usedHooks as $hook) {
            if (!$this->unregisterHook($hook)) {
                return false;
            }
        }

        $configurationService = new \GetResponse\Configuration\Application\ConfigurationService(
            new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
        );
        $configurationService->deleteAllConfigurations();

        if (!Configuration::deleteByName('GR_VERSION')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function uninstallTab()
    {
        $idTab = (int) Tab::getIdFromClassName('AdminGetresponse');
        if (empty($idTab)) {
            return false;
        }

        $tab = new Tab($idTab);

        return $tab->delete();
    }

    public function hookActionNewsletterRegistrationAfter($params)
    {
        try {
            $email = $params['email'];

            if (null !== $email) {
                $shop = new Shop($this->context->shop->id);
                $contactService = new \GetResponse\Contact\Application\ContactService(
                    new \GetResponse\MessageSender\Application\MessageSenderService(
                        new \GetResponse\MessageSender\Infrastructure\HttpClient($shop->getBaseURL())
                    ),
                    new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
                        new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
                    )
                );

                $contactService->upsertSubscriber(new \GetResponse\Contact\Application\Command\UpsertSubscriber($email, true, $shop->id));
            }
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionObjectCustomerUpdateAfter($params)
    {
        try {
            /** @var Customer $customer */
            $customer = $params['object'];

            if (null !== $customer) {
                $this->upsertCustomer($customer);
            }
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionCustomerAccountAdd($params)
    {
        try {
            /** @var Customer $customer */
            $customer = $params['newCustomer'];

            if (null !== $customer) {
                $this->upsertCustomer($customer);
            }
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookCart($params)
    {
        try {
            /** @var Cart $cart */
            $cart = $params['cart'];

            // sometimes it happens
            if (null === $cart) {
                return;
            }

            $shop = new Shop($cart->id_shop);

            $cartService = new \GetResponse\Ecommerce\Application\CartService(
                new \GetResponse\MessageSender\Application\MessageSenderService(
                    new \GetResponse\MessageSender\Infrastructure\HttpClient($shop->getBaseURL())
                ),
                new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
                    new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
                )
            );
            $cartService->upsertCart(new \GetResponse\Ecommerce\Application\Command\UpsertCart($cart->id, $shop->id));
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionObjectAddressUpdateAfter($params)
    {
        try {
            /** @var Address $address */
            $address = $params['object'];

            if ($address !== null && null !== $address->id_customer) {
                $this->upsertCustomer(new Customer($address->id_customer));
            }
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionObjectAddressAddAfter($params)
    {
        try {
            /** @var Address $address */
            $address = $params['object'];

            if ($address !== null && null !== $address->id_customer) {
                $this->upsertCustomer(new Customer($address->id_customer));
            }
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionProductAdd($params)
    {
        try {
            /** @var Product $product */
            $product = $params['product'];

            if (null !== $product) {
                $this->upsertProduct($product);
            }
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionProductUpdate($params)
    {
        try {
            /** @var Product $product */
            $product = $params['product'];

            if (null !== $product) {
                $this->upsertProduct($product);
            }
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookNewOrder($params)
    {
        try {
            /** @var Order $order */
            $order = $params['order'];

            if (null === $order) {
                return;
            }

            $this->upsertOrder($order);
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        } catch (\Exception $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        try {
            if (null === $params['id_order']) {
                return;
            }

            $order = new Order($params['id_order']);

            $this->upsertOrder($order);
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        } catch (\Exception $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    public function hookActionOrderEdited($params)
    {
        try {
            /** @var Order $order */
            $order = $params['order'];

            if (null === $order) {
                return;
            }

            $this->upsertOrder($order);
        } catch (\GetResponse\MessageSender\Application\MessageSenderException $e) {
            $this->logGetResponseError($e->getMessage());
        } catch (\Exception $e) {
            $this->logGetResponseError($e->getMessage());
        }
    }

    /**
     * @param string $message
     */
    private function logGetResponseError($message)
    {
        PrestaShopLoggerCore::addLog($message, 2, null, 'GetResponse', 'GetResponse');
    }

    /**
     * @param \GetResponse\Configuration\ReadModel\ConfigurationDto $configurationDto
     *
     * @return false|string|null
     */
    private function getWebTrackingCustomerEmailSnippet($configurationDto)
    {
        if (empty($configurationDto->getGetResponseWebTrackingSnippet())) {
            return null;
        }

        if (empty($this->context->customer->email)) {
            return null;
        }

        $customerEmail = $this->context->customer->email;
        $this->smarty->assign(['customerEmail' => $customerEmail]);
        $templatePath = 'views/templates/front/getresponse_web_tracking_set_customer_email_snippet.tpl';

        return $this->display(__FILE__, $templatePath);
    }

    /**
     * @param string $snippet
     *
     * @return false|string|null
     */
    private function renderSnippet($snippet)
    {
        if (empty($snippet)) {
            return null;
        }
        $this->smarty->assign(['snippet' => $snippet]);
        $templatePath = 'views/templates/front/getresponse_snippet.tpl';

        return $this->display(__FILE__, $templatePath);
    }

    /**
     * @param \GetResponse\Configuration\ReadModel\ConfigurationDto $configuration
     * @param string $position
     *
     * @return false|string|null
     */
    private function getGrWebFormSnippet($configuration, $position)
    {
        if (!$configuration->hasWebForm()) {
            return null;
        }

        if ($configuration->getGetResponseWebFormPosition() !== $position) {
            return null;
        }

        $templateVars = [
            'webformUrl' => $configuration->getGetResponseWebFormUrl(),
            'position' => $configuration->getGetResponseWebFormPosition(),
        ];

        $this->smarty->assign($templateVars);

        return $this->display(__FILE__, 'views/templates/front/getresponse_webform.tpl');
    }

    /**
     * @throws \GetResponse\MessageSender\Application\MessageSenderException
     *
     * @param Customer $customer
     */
    private function upsertCustomer(Customer $customer)
    {
        $shop = new Shop($customer->id_shop);
        $contactService = new \GetResponse\Contact\Application\ContactService(
            new \GetResponse\MessageSender\Application\MessageSenderService(
                new \GetResponse\MessageSender\Infrastructure\HttpClient($shop->getBaseURL())
            ),
            new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
                new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
            )
        );

        $contactService->upsertCustomer(
            new \GetResponse\Contact\Application\Command\UpsertCustomer($customer->id, $shop->id)
        );
    }

    /**
     * @throws \GetResponse\MessageSender\Application\MessageSenderException
     *
     * @param Product $product
     */
    private function upsertProduct(Product $product)
    {
        if (null === \ShopCore::getContextShopID()) {
            return;
        }

        $languageId = \Configuration::get('PS_LANG_DEFAULT');
        $shops = $product->getAssociatedShops();

        foreach ($shops as $shopId) {
            $shop = new \Shop($shopId);

            $productService = new \GetResponse\Ecommerce\Application\ProductService(
                new \GetResponse\MessageSender\Application\MessageSenderService(
                    new \GetResponse\MessageSender\Infrastructure\HttpClient($shop->getBaseURL())
                ),
                new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
                    new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
                )
            );

            $productService->upsertProduct(
                new \GetResponse\Ecommerce\Application\Command\UpsertProduct((int) $shopId, $product->id, (int) $languageId)
            );
        }
    }

    /**
     * @throws \GetResponse\MessageSender\Application\MessageSenderException
     *
     * @param Order $order
     */
    private function upsertOrder(Order $order)
    {
        $shop = new \Shop($order->id_shop);
        $orderService = new GetResponse\Ecommerce\Application\OrderService(
            new \GetResponse\MessageSender\Application\MessageSenderService(
                new \GetResponse\MessageSender\Infrastructure\HttpClient($shop->getBaseURL())
            ),
            new \GetResponse\Configuration\ReadModel\ConfigurationReadModel(
                new \GetResponse\Configuration\Infrastructure\ConfigurationRepository()
            )
        );

        $orderService->upsertOrder(new GetResponse\Ecommerce\Application\Command\UpsertOrder($order->id, $order->id_shop));
    }
}
