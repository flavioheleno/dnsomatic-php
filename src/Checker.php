<?php

namespace dnsomatic;

use \GuzzleHttp\Client;

/*
 * DNS-O-Matic IP Address resolution client.
 */
class Checker {
    /**
     * DNS-O-Matic IP Address resolution service host.
     */
    const SERVICE_HOST = 'myip.dnsomatic.com';

    /**
     * User Agent identification.
     *
     * @var string
     */
    private $userAgent = 'DNS-O-Matic-PHP/0.1 (checker)';

    /**
     * Returns the resolution url.
     *
     * @return string
     */
    private function getServiceUrl() : string {
        return sprintf('http://%s/', self::SERVICE_HOST);
    }

    /**
     * Class constructor.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Gets the User Agent.
     *
     * @return string
     */
    public function getUserAgent() : string {
        return $this->userAgent;
    }

    /**
     * Sets the User Agent.
     *
     * @param string $userAgent
     *
     * @return self
     */
    public function setUserAgent(string $userAgent) : self {
        $this->userAgent = $userAgent;
    }

    /**
     * Executes DNS-O-Matic IP Address resolution.
     *
     * @throws \dnsomatic\Exception\InvalidIPAddress
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return string
     */
    public function exec() : string {
        $response = $this->client->request(
            'GET',
            $this->getServiceUrl(),
            [
                'headers' => [
                    'User-Agent' => $this->userAgent
                ]
            ]
        );

        $body = (string) $response->getBody();
        if (! filter_var($body, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4 | \FILTER_FLAG_IPV6)) {
            throw new Exception\InvalidIPAddress();
        }

        return $body;
    }
}
