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

require_once __DIR__ . '/Unit/PrestashopMock/Customer.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/CustomerParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Currency.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/CurrencyParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Cart.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/CartParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Product.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/ProductParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Shop.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/ShopParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Link.php';
require_once __DIR__ . '/Unit/PrestashopMock/Category.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/CategoryParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Image.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/ImageParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/ImageType.php';
require_once __DIR__ . '/Unit/PrestashopMock/Tools.php';
require_once __DIR__ . '/Unit/PrestashopMock/Order.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/OrderParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Address.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/AddressParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Country.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/CountryParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/State.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/StateParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/OrderState.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/OrderStateParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Combination.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/CombinationParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Tools.php';
require_once __DIR__ . '/Unit/PrestashopMock/MockParams/ManufacturerParams.php';
require_once __DIR__ . '/Unit/PrestashopMock/Manufacturer.php';

define('__PS_BASE_URI__', 'https://my-prestashop.com/');
define('_PS_BASE_URL_', 'https://my-prestashop.com/');
define('_THEME_PROD_DIR_', 'img/p/');
