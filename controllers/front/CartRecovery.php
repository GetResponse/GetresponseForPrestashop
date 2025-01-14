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

use GetResponse\SharedKernel\CartRecoveryHelper;

if (!defined('_PS_VERSION_')) {
    exit;
}

class GrPrestashopCartRecoveryModuleFrontController extends ModuleFrontController
{
    public function init(): void
    {
        $queryParams = Tools::getAllValues();

        if (empty($queryParams['cart_id']) || empty($queryParams['cart_token'])) {
            $this->showErrorFlashMessage();
        }
        $cartId = $queryParams['cart_id'];

        if ($queryParams['cart_token'] != CartRecoveryHelper::generateCartToken($cartId)) {
            $this->showErrorFlashMessage();
        }

        $recoveredCart = new Cart($cartId);
        if (!Validate::isLoadedObject($recoveredCart)) {
            $this->showErrorFlashMessage();
        }

        $this->context->cart = $recoveredCart;
        $this->context->cookie->id_cart = (int) $recoveredCart->id; // @phpstan-ignore-line

        $link = $this->context->link ? $this->context->link : new Link();

        $redirectLink = $link->getPageLink('cart', null, null, ['action' => 'show']);
        Tools::redirect($redirectLink);
    }

    private function showErrorFlashMessage(): void
    {
        $this->errors[] = $this->l('We could not recover your cart');
        $this->redirectWithNotifications('index.php');
    }
}
