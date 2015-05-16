<?php

/**
 * Version Control Service (VCS) Statistics System API
 * This is the common message class for alltype of VCS 
 * to show descriptive message to user about action
 *  
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */

namespace lib\shared;

/**
 * class for creating message strings 
 * (this should be go into the string lang file)
 */
class message {

    /**
     * define constants to show messages
     */
    const HELP_MESSAGE = 'API commands to get statistics details of version control system repository - 1. To get contributor count: php index.php commits -count -u username -p ******** https://github.com/username/repositoryname  contributorname';
    const SERVICE_NOT_FOUND = 'Requested version control service not found.';
    const RECORD_NOT_FOUND = 'No record found for given inputs.';
    const STATISTIC_TYPE_REQUIRED = 'Statistic type is required.';
    const USERNAME_REQUIRED = 'Username is required.';
    const PASSWORD_REQUIRED = 'Password is required.';
    const REPOSITORY_URL_REQUIRED = 'Repository url is required.';
    const CONTRIBUTOR_NAME_REQUIRED = 'Contributor name is required.';
    const INCOREECT_COMMAND = 'Command is incorrect.';

}
