<?php

namespace dnsomatic;

use \GuzzleHttp\Client;

/*
 * DNS-O-Matic updater client.
 */
class Updater {
    /**
     * DNS-O-Matic update service host.
     */
    const SERVICE_HOST = 'updates.dnsomatic.com';
    /**
     * DNS-O-Matic update service path.
     */
    const SERVICE_PATH = '/nic/update';
    /**
     * Hostname definition for all hosts.
     */
    const ALL_HOSTNAMES = 'all.dnsomatic.com';
    /**
     * Wildcard enable value.
     */
    const WILDCARD_ENABLED = 'ON';
    /**
     * Wildcard disable value.
     */
    const WILDCARD_DISABLED = 'OFF';
    /**
     * Wildcard preservation value.
     */
    const WILDCARD_PRESERVED = 'NOCHG';
    /**
     * MX preservation value.
     */
    const MX_PRESERVED = 'NOCHG';
    /**
     * Back MX enable value.
     */
    const BACKMX_ENABLED = 'YES';
    /**
     * Back MX disable value.
     */
    const BACKMX_DISABLED = 'NO';
    /**
     * Back MX preservation value.
     */
    const BACKMX_PRESERVED = 'NOCHG';

    /**
     * Flag for HTTPS.
     *
     * @var boolean
     */
    private $useHTTPS = true;
    /**
     * User Agent identification.
     *
     * @var string
     */
    private $userAgent = 'DNS-O-Matic-PHP/0.1 (updater)';
    /**
     * DNS-O-Matic username.
     *
     * @var string
     */
    private $username;
    /**
     * DNS-O-Matic password.
     *
     * @var string
     */
    private $password;
    /**
     * Hostname update parameter.
     *
     * @var string
     */
    private $hostname = self::ALL_HOSTNAMES;
    /**
     * IP Address update parameter.
     *
     * @var string
     */
    private $myip;
    /**
     * Wildcard update parameter.
     *
     * @var string
     */
    private $wildcard = self::WILDCARD_PRESERVED;
    /**
     * MX update parameter.
     *
     * @var string
     */
    private $mx = self::MX_PRESERVED;
    /**
     * Back MX update parameter.
     *
     * @var string
     */
    private $backMx = self::BACKMX_PRESERVED;
    /**
     * Raw DNS-O-Matic response.
     *
     * @var string
     */
    private $rawResponse;

    /**
     * Returns the service url.
     *
     * @return string
     */
    private function getServiceUrl() : string {
        $schema = 'http';
        if ($this->useHTTPS) {
            $schema .= 's';
        }

        return sprintf('%s://%s%s', $schema, self::SERVICE_HOST, self::SERVICE_PATH);
    }

    /**
     * Returns the body request as an array.
     *
     * @return array
     */
    private function getRequestBody() : array {
        $body = [];

        if ($this->hostname !== null) {
            $body['hostname'] = $this->hostname;
        }

        if ($this->myip !== null) {
            $body['myip'] = $this->myip;
        }

        if ($this->wildcard !== null) {
            $body['wildcard'] = $this->wildcard;
        }

        if ($this->mx !== null) {
            $body['mx'] = $this->mx;
        }

        if ($this->backMx !== null) {
            $body['backmx'] = $this->backMx;
        }

        return $body;
    }

    /**
     * Class constructor.
     *
     * @param \GuzzleHttp\Client $client
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function __construct(Client $client, string $username, string $password) {
        $this->client   = $client;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Enables HTTPS (default; updates using HTTP over SSL/TLS on port 443).
     *
     * @return self
     */
    public function enableHTTPS() : self {
        $this->useHTTPS = true;

        return $this;
    }

    /**
     * Disables HTTPS (updates using HTTP over port 80).
     *
     * @return self
     */
    public function disableHTTPS() : self {
        $this->useHTTPS = false;

        return $this;
    }

    /**
     * Returns if HTTPS is enabled.
     *
     * @return boolean
     */
    public function isHTTPSEnabled() : bool {
        return $this->useHTTPS === true;
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
     * Gets the hostname.
     *
     * @return string
     */
    public function getHostname() : string {
        return $this->hostname;
    }

    /**
     * Sets the hostname.
     *
     * Hostname you wish to update. To update all services registered with DNS-O-Matic to the new IP address,
     * hostname may be omitted or set to Updater::ALL_HOSTNAMES.
     *
     * @param string $hostname
     *
     * @return self
     */
    public function setHostname(string $hostname) : self {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Gets the IP Address.
     *
     * @return string
     */
    public function getMyip() : string {
        return $this->myip;
    }

    /**
     * Sets the IP Address.
     *
     * IP address to set for the update. If not specified, the best IP address the server can determine will be used
     * (some proxy configurations pass the IP in a header, and that is detected by the server).
     *
     * @param string $myip
     *
     * @return self
     */
    public function setMyip(string $myip) : self {
        $this->myip = $myip;

        return $this;
    }

    /**
     * Enables wildcard for this host.
     *
     * @return self
     */
    public function enableWildcard() : self {
        $this->wildcard = self::WILDCARD_ENABLED;

        return $this;
    }

    /**
     * Disables wildcard for this host.
     *
     * @return self
     */
    public function disableWildcard() : self {
        $this->wildcard = self::WILDCARD_DISABLED;

        return $this;
    }

    /**
     * Returns if wildcard is enabled.
     *
     * @return boolean
     */
    public function isWildcardEnabled() : bool {
        return $this->wildcard === self::WILDCARD_ENABLED;
    }

    /**
     * Returns if wildcard is preserved.
     *
     * @return boolean
     */
    public function isWildcardPreserved() : bool {
        return $this->wildcard === self::WILDCARD_PRESERVED;
    }

    /**
     * Gets the MX value.
     *
     * @return string
     */
    public function getMx() : string {
        return $this->mx;
    }

    /**
     * Sets the MX value.
     *
     * Specifies a Mail eXchanger for use with the hostname being modified. The specified MX must resolve to an IP
     * address, or it will be ignored. Specifying an MX of Updater::MX_PRESERVED will cause the existing MX setting
     * to be preserved in whatever state it was previously updated.
     *
     * @param string $mx
     *
     * @return self
     */
    public function setMx(string $mx) : self {
        $this->mx = $mx;

        return $this;
    }

    /**
     * Enables Back MX.
     *
     * Requests the MX value in the MX parameter to be set up as a backup MX by listing the host itself as an MX
     * with a lower preference value.
     *
     * @return self
     */
    public function enableBackMx() : self {
        $this->backMx = self::BACKMX_ENABLED;

        return $this;
    }

    /**
     * Disables Back MX.
     *
     * Keeps the previous Back MX value.
     *
     * @return self
     */
    public function disableBackMx() : self {
        $this->backMx = self::BACKMX_DISABLED;

        return $this;
    }

    /**
     * Returns if Back MX is enabled.
     *
     * @return boolean
     */
    public function isBackMxEnabled() : bool {
        return $this->backMx === self::BACKMX_ENABLED;
    }

    /**
     * Returns if Back MX is preserved.
     *
     * @return boolean
     */
    public function isBackMxPreserved() : bool {
        return $this->backMx === self::BACKMX_PRESERVED;
    }

    /**
     * Gets the raw response from DNS-O-Matic.
     *
     * @return string|null
     */
    public function getRawResponse() : ?string {
        return $this->rawResponse;
    }

    /**
     * Executes DNS-O-Matic update.
     *
     * @throws \dnsomatic\Exception\Abuse
     * @throws \dnsomatic\Exception\BadAgent
     * @throws \dnsomatic\Exception\BadAuth
     * @throws \dnsomatic\Exception\DNSErr
     * @throws \dnsomatic\Exception\IgnoredRequest
     * @throws \dnsomatic\Exception\InvalidResponse
     * @throws \dnsomatic\Exception\NineEleven
     * @throws \dnsomatic\Exception\NoHost
     * @throws \dnsomatic\Exception\NotFQDN
     * @throws \dnsomatic\Exception\NumHost
     * @throws \dnsomatic\Exception\UnknownResponse
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return bool True if update was successful; False if it did not change the dns record.
     */
    public function exec() : bool {
        $response = $this->client->request(
            'POST',
            $this->getServiceUrl(),
            [
                'auth' => [
                    $this->username,
                    $this->password
                ],
                'form_params' => $this->getRequestBody(),
                'headers' => [
                    'User-Agent' => $this->userAgent
                ]
            ]
        );

        $this->rawResponse = (string) $response->getBody();

        if (! preg_match('/^([^ ]+) ([^ ]+) ?([^ ]+)? ?(.*?)?$/', $this->rawResponse, $matches)) {
            throw new Exception\InvalidResponse();
        }

        switch (strtolower($matches[1])) {
            case 'badauth':
                throw new Exception\BadAuth();
            case 'notfqdn':
                throw new Exception\NotFQDN();
            case 'nohost':
                throw new Exception\NoHost();
            case 'numhost':
                throw new Exception\NumHost();
            case 'abuse':
                throw new Exception\Abuse();
            case 'badagent':
                throw new Exception\BadAgent();
            case 'dnserr':
                throw new Exception\DNSErr();
            case '911':
                throw new Exception\NineEleven();
            case 'good':
                if (($matches[2] === '127.0.0.1') && ($matches[2] !== $this->myip)) {
                    throw new Exception\IgnoredRequest();
                }

                return true;
            case 'nochg':
                return false;
            default:
                throw new Exception\UnknownResponse();
        }
    }
}
