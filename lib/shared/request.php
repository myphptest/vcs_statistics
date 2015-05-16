<?php

/**
 * Version Control Service (VCS) Statistics System API
 * This is the shared class among all VCS type to send the request to the API
 * by using curl
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */

namespace lib\shared;

use lib\shared\response;
use lib\shared\exception;

/**
 * To create a class for sending request using curl
 */
class request extends response {

    /**
     * intialize class variables
     *  
     * @var array $config 
     */
    protected $config = array(
        'port' => '443',
        'timeout' => '30',
        'userAgent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
    );

    /**
     * http codes for positive response
     *  
     * @var array $arrHttpCodes 
     */
    protected $httpcodes = array(0, 200, 201);

    /**
     * to get the configuration of curl request
     * 
     * @access public
     * @param string $name
     * @return string
     */
    public function getConfig($name = '') {
        if (!empty($name) && isset($this->config[$name])) {
            return $this->config[$name];
        }
        return $this->config;
    }

    /**
     * to process  curl request
     * 
     * @access public
     * 
     * @param string $url   URL to be hit
     * @param array $options    Curl Options
     * @param type $parameters  Extra parameters
     * @param type $httpMethod  Http Method(default: GET)
     * @return mixed 
     * @throws \Exception
     */
    public function executeRequest($url, $options = array(), $parameters = array(), $httpMethod = 'GET') {

        $curl = curl_init();

        $curlOptions = $this->prepareRequest($url, $options, $parameters, $httpMethod);

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        $headers = curl_getinfo($curl);
        $errorNumber = curl_errno($curl);
        $errorMessage = curl_error($curl);

        curl_close($curl);

        if (!in_array($headers['http_code'], $this->httpcodes)) {
            throw new exception($errorMessage, (int) $headers['http_code']);
        }

        if (!empty($errorNumber)) {
            throw new exception($errorMessage, $errorNumber);
        }

        return $response;
    }

    /**
     * prepare request object with user's provided information
     * 
     * @access protected
     * 
     * @param string $url   URL to be hit
     * @param array $options    Curl Options
     * @param type $parameters  Extra parameters
     * @param type $httpMethod  Http Method(default: GET)
     * 
     * @return array 
     * 
     */
    protected function prepareRequest($url, $options = array(), $parameters = array(), $httpMethod = 'GET') {

        $curlOptions = array();

        if (isset($options['username']) && isset($options['password'])) {
            $curlOptions += array(
                CURLOPT_USERPWD => $options['username'] . ':' . $options['password'],
            );
        }

        if (!empty($parameters)) {
            $queryString = utf8_encode(http_build_query($parameters, '', '&'));

            if ('GET' === $httpMethod) {
                $url .= '?' . $queryString;
            } else {
                $curlOptions += array(
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $queryString
                );
            }
        }

        $curlOptions += array(
            CURLOPT_URL => $url,
            CURLOPT_PORT => $this->getConfig('port'),
            CURLOPT_USERAGENT => $this->getConfig('userAgent'),
            CURLOPT_TIMEOUT => $this->getConfig('timeout'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );

        return $curlOptions;
    }

}
