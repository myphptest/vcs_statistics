<?php

/**
 * Version Control Service (VCS) Statistics System API
 * Command process file
 * this class is used to instantiate the choosen service in command
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */
use lib\shared\exception;
use lib\shared\message;
use service\type\bitbucket;
use service\type\github;

/**
 * to process requested vcs service statistic / event 
 */
class process {

    /**
     * initialize member variables
     * 
     * @var object | null 
     */
    private $_serviceInstance = null;

    /**
     * Instantiate service instance by identifying requested repository url
     * in user's input
     * 
     * @access public
     * 
     * @param   array  $inputs holds the user's given inputs
     * @throws Exception When no service found.
     * @return  void
     */
    public function setServiceInstance($inputs = array()) {

        // to get service type by extracting hostname in repository url
        $serviceType = $this->_extractServiceType($inputs);

        if ($serviceType == VCS_STATISTICS_GITHUB_HOST) {
            $this->_setGithubInstance($inputs);
        } else if ($serviceType == VCS_STATISTICS_BITBUCKET_HOST) {
            $this->_setBitbucketInstance($inputs);
        }

        if (is_null($this->_serviceInstance)) {
            throw new exception(message::SERVICE_NOT_FOUND);
        }
    }

    /**
     * Get requested service instance
     * 
     * @access public
     * 
     * @return  object
     */
    public function getServiceInstance() {
        return $this->_serviceInstance;
    }

    /**
     * Instantiate github class and set setvice instance
     * 
     * @access protected
     * @param array $inputs User's inputs
     * 
     * @return  void
     */
    protected function _setGithubInstance($inputs) {
        $this->_serviceInstance = new github($inputs);
    }

    /**
     * Instantiate bitbucket class and set setvice instance
     * 
     * @access protected
     * @param array $inputs User's inputs
     * 
     * @return  void
     */
    protected function _setBitbucketInstance($inputs) {
        $this->_serviceInstance = new bitbucket($inputs);
    }

    /**
     * to identify service as hostnsme
     * using requested repository url in given user's inputs
     * 
     * @access private
     * 
     * @param   array  $inputs
     * 
     * @return  string
     */
    private function _extractServiceType(& $inputs) {

        $hostName = '';
        $repositoryUrl = $inputs['repositoryUrl'];
        $temp = parse_url($repositoryUrl);
        $inputs = $inputs + $temp;

        if (isset($inputs['host']) && !empty($inputs['host'])) {
            $hostName = $inputs['host'];
        }

        return $hostName;
    }

}
