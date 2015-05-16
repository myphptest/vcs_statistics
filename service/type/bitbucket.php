<?php

/**
 * Version Control Service (VCS) Statistics System API
 * Maanage Bitbucket Service API
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */

namespace service\type;

use lib\shared\request;
use lib\shared\base;

/**
 * class to get event statistics on bitbucket repository using apis service
 */
class bitbucket extends request implements base {

    /**
     * this holds all the bitbucket API url according to statistic/event type
     * array key hold the event name
     * and array value holds corresponding event API url
     * 
     * @access private
     * @var array
     */
    private $_bitbucketApis = array(
        'commits' => 'https://bitbucket.org/api/2.0/repositories/:repository/commits'
    );

    /**
     * input options required for requesting API url
     * 
     * @access private
     * @var array
     */
    private $_inputs = array(
        'dataType' => 'json',
    );

    /**
     * initialize member varialbles
     * 
     * @access public
     * 
     * @param array $inputs    User Inputs
     */
    public function __construct($inputs = array()) {
        $this->setInputs($inputs);
    }

    /**
     * Get Bitbucket available api url's or a single api based on key
     * 
     * @access public
     * 
     * @param string $key    API key / event
     * 
     * @return mixed
     */
    public function getBitbucketApis($key = '') {
        if (!empty($key) && isset($this->_bitbucketApis[$key])) {

            return $this->_bitbucketApis[$key];
        }

        return $this->_bitbucketApis;
    }

    /**
     * To get all user's inputs or a single user's input based on key
     * 
     * @access public
     * 
     * @param string $key    API key
     * @return mixed
     */
    public function getInputs($key = '') {

        if (!empty($key) && isset($this->_inputs[$key])) {

            return $this->_inputs[$key];
        }
        return $this->_inputs;
    }

    /**
     * Set user's inputs
     * 
     * @access public
     * 
     * @param array $inputs    User Inputs
     * @return void
     */
    public function setInputs($inputs) {

        $this->_inputs += $inputs;

        return $this;
    }

    /**
     * This handles the bitbucket event commit API
     * for determining the contributors commit count on given bitbucket repository
     * 
     * @access public
     * 
     * @return mixed
     */
    public function getCommitCount() {

        $apiUrl = $this->getBitbucketApis('commits');

        $url = strtr($apiUrl, array(
            ':repository' => substr($this->getInputs('path'), 1)
        ));

        $output = $this->executeRequest($url, $this->getInputs());

        $formattedResponse = $this->parseResponse($output, $this->getInputs('dataType'));

        $contributors = array();

        if (count($formattedResponse) > 0) {

            foreach ($formattedResponse['values'] as $contributor) {

                $userName = isset($contributor['author']['user']['username']) ? $contributor['author']['user']['username'] : '';
                if (!empty($userName)) {
                    if (array_key_exists($userName, $contributors)) {
                        $contributors[$userName] += 1;
                    } else {
                        $contributors[$userName] = 1;
                    }
                }
            }
        }

        $contributorName = $this->getInputs('contributorName');

        if (!empty($contributorName)) {
            $totalCount = isset($contributors[$contributorName]) ? $contributors[$contributorName] : 0;
            return array($contributorName => $totalCount);
        }

        return $contributors;
    }

}
