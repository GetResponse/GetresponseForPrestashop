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

namespace GetResponse\Contact\DomainModel;

use GetResponse\SharedKernel\CallbackType;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Subscriber implements \JsonSerializable
{
    /** @var string */
    private $email;
    /** @var bool */
    private $marketingConsent;
    /** @var string|null */
    private $name;

    public function __construct($email, $marketingConsent, $name)
    {
        $this->email = $email;
        $this->marketingConsent = $marketingConsent;
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'callback_type' => CallbackType::SUBSCRIBERS_UPDATE,
            'email' => $this->email,
            'name' => $this->name,
            'accepts_marketing' => (bool) $this->marketingConsent,
        ];
    }
}
