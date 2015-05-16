<?php

/**
 * Version Control Service (VCS) Statistics System API
 * This is the base class for alltype of VCS contains generalize functions to
 * calulate the statistics
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */

namespace lib\shared;

/**
 * interface that contains common methods to get VCS statistics
 * 
 */
interface base {

    /**
     * This function is used to get number of commits count of a contributor 
     * on the VCS like github, bitbucket.
     * 
     * @access public
     * 
     * @return mixed
     */
    public function getCommitCount();
}
