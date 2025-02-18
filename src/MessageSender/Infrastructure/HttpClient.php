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

namespace GetResponse\MessageSender\Infrastructure;

use GetResponse\MessageSender\DomainModel\EventEmitter;
use GetResponse\MessageSender\DomainModel\EventEmitterException;

if (!defined('_PS_VERSION_')) {
    exit;
}

class HttpClient implements EventEmitter
{
    const GET = 'GET';
    const POST = 'POST';
    const TIMEOUT = 8;
    const API_APP_SECRET = '010b02c432482c288dca40f5dae0b132';

    /** @var string */
    private $shopDomain;

    public function __construct(string $shopDomain)
    {
        $this->shopDomain = $shopDomain;
    }

    /**
     * @param string $url
     * @param \JsonSerializable $object
     * @param string $method
     *
     * @return array<string, mixed>
     *
     * @throws EventEmitterException
     */
    private function sendRequest(string $url, \JsonSerializable $object, string $method = self::GET): array
    {
        $headers = [
            'Content-Type: application/json',
            'X-Shop-Domain: ' . $this->shopDomain,
            'X-Hmac-Sha256: ' . $this->createHmac($object),
            'X-Timestamp: ' . date('Y-m-d H:i:s.') . gettimeofday()['usec'],
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_HTTPHEADER => $headers,
        ];

        if ($method === self::POST) {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = json_encode($object->jsonSerialize());
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if (false === $response) {
            $error_message = curl_error($curl);
            curl_close($curl);
            throw EventEmitterException::createFromCurlError($error_message);
        }

        if (!empty($response)) {
            $response = json_decode((string) $response, true);
        } else {
            $response = [];
        }
        curl_close($curl);

        return $response;
    }

    /**
     * @param string $url
     * @param \JsonSerializable $object
     *
     * @return array<string, mixed>
     *
     * @throws EventEmitterException
     */
    public function emit($url, $object): array
    {
        return $this->sendRequest($url, $object, self::POST);
    }

    /**
     * @param \JsonSerializable $object
     *
     * @return string
     */
    private function createHmac(\JsonSerializable $object): string
    {
        $json = json_encode($object->jsonSerialize());
        if ($json === false) {
            throw new \RuntimeException('Failed to encode JSON');
        }

        return base64_encode(
            hash_hmac('sha256', $json, self::API_APP_SECRET, true)
        );
    }
}
