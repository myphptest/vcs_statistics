<?php

/**
 * Version Control Service (VCS) Statistics System API
 * Manage Github Service API
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */

namespace service\type;

use lib\shared\request;
use lib\shared\base;

/**
 * class to get statistics on github repository using apis service
 */
class github extends request implements base {

    /**
     * this holds all the Github API url according to statistic type
     * array key hold the event name
     * and array value holds corresponding statistics API url
     * 
     * @access private
     * @var array
     */
    private $_gitApis = array(
        'contributors' => 'https://api.github.com/repos/:repository/contributors'
    );

    /**
     * input options required for requesting API url
     * @access private
     * @var array
     */
    private $_inputs = array(
        'dataType' => 'json',
    );

    /**
     * initialize member variables
     * 
     * @access public
     * 
     * @param array $inputs    User Inputs
     */
    public function __construct($inputs = array()) {
        $this->setInputs($inputs);
    }

    /**
     * Get Github available api url's or a single api based on key
     * 
     * @access public
     * 
     * @param string $key    API key
     * 
     * @return mixed
     */
    public function getGitApis($key = '') {
        if (!empty($key) && isset($this->_gitApis[$key])) {
            return $this->_gitApis[$key];
        }
        return $this->_gitApis;
    }

    /**
     * Get user input options or a single user input based on key
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
     * Set user input options
     * 
     * @access public
     * 
     * @param options $options    User Inputs
     * @return void
     */
    public function setInputs($inputs) {
        $this->_inputs += $inputs;
    }

    /**
     * This handles the github statistics commit API
     * for determining the contributors commit count on given github repository
     * 
     * @access public
     * 
     * @return mixed
     */
    public function getCommitCount() {

        $apiUrl = $this->getGitApis('contributors');

        $url = strtr($apiUrl, array(
            ':repository' => substr($this->getInputs('path'), 1)
        ));

        $output = $this->executeRequest($url, $this->getInputs());
        $formattedResponse = $this->parseResponse($output, $this->getInputs('dataType'));

        // process the reponse from contributors API from Github
        $contributors = array();

        if (count($formattedResponse) > 0) {
            foreach ($formattedResponse as $contributor) {
                $contributors[$contributor['login']] = $contributor['contributions'];
            }
        }

        $contributorName = $this->getInputs('contributorName');
        if (!empty($contributorName)) {
            return array($contributorName => $contributors[$contributorName]);
        }

        return $contributors;
    }

}
