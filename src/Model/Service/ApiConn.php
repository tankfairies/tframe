<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Tframe\Model\Service;

/**
 * Curl API wrapper
 *
 * Class ApiConn
 * @package Model\Service
 */
class ApiConn
{
    const RETRIES = 15;

    private $url;
    private $params = [];
    private $ch;

    /**
     * Sets the URL
     *
     * @param string $url
     * @return ApiConn
     */
    public function setUrl(string $url): ApiConn
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Defines the curl params
     *
     * @param array $params
     * @return ApiConn
     */
    public function setParams(array $params): ApiConn
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Makes the call and returns the response
     *
     * @return array
     * @throws ApiConnException
     */
    public function getResponse(): array
    {

        if (empty($this->url)) {
            throw new ApiConnException('url not set');
        }

        if (!empty($this->params)) {
            $this->url .= '?'.http_build_query($this->params);
        }

        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        $response = $this->callExec();

        // close cURL resource, and free up system resources
        curl_close($this->ch);

        return $response;
    }

    /**
     * Execute the curl call
     *
     * @return array
     * @throws ApiConnException
     */
    private function callExec(): array
    {
        $i = 0;
        while ($i < self::RETRIES) {
            $out = curl_exec($this->ch);

            if ($out === false) {
                throw new ApiConnException('connection error: ' . curl_error($this->ch));
            }

            $response = json_decode($out, true);

            if (json_last_error() == JSON_ERROR_NONE && !isset($response->error)) {
                return $response;
            }

            sleep(1);
            $i++;
        }

        throw new ApiConnException('connection failure');
    }
}