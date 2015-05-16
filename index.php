<?php

/**
 * Version Control Service (VCS) Statistics System API
 * This API is used to find/calculate different type of statistics
 * related to different type of VCS like github, bitbucket etc.
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */
require_once 'includes.php';

use lib\shared\message;

// define user's input array
// to hold user's inputs like username, password, statistic type, repository url etc.
$inputs = array(
    'username' => '',
    'password' => '',
    'repositoryUrl' => '',
    'contributorName' => '',
    'statistictype' => '',
);

// validate the user's inputs
$flag = 0;
if (count($argv) == 1) {
    $flag = 1;
    $message = message::HELP_MESSAGE;
} else if (empty($argv[1])) {
    $flag = 1;
    $message = message::STATISTIC_TYPE_REQUIRED;
} else if (empty($argv[4])) {
    $flag = 1;
    $message = message::USERNAME_REQUIRED;
} else if (empty($argv[6])) {
    $flag = 1;
    $message = message::PASSWORD_REQUIRED;
} else if (empty($argv[7])) {
    $flag = 1;
    $message = message::REPOSITORY_URL_REQUIRED;
} else if (empty($argv[8])) {
    $flag = 1;
    $message = message::CONTRIBUTOR_NAME_REQUIRED;
} else if (count($argv) !== 9) {
    $flag = 1;
    $message = message::INCOREECT_COMMAND;
}

if ($flag) {
    echo $message;
    die();
}

// now, initialize the input array with given user's input
$inputs = array(
    'username' => $argv[4],
    'password' => $argv[6],
    'repositoryUrl' => $argv[7],
    'contributorName' => $argv[8],
    'statistictype' => $argv[1],
);

// process the command
$processObj = new process();
$processObj->setServiceInstance($inputs);
$serviceObj = $processObj->getServiceInstance();
// call the service method according to the given statistic type
if ($inputs['statistictype'] == VCS_STATISTICS_TYPE_TOTAL_COMMIT) {
    $arrContributorsCommitCount = $serviceObj->getCommitCount();
    $serviceObj->showResponse(VCS_STATISTICS_TYPE_TOTAL_COMMIT, $arrContributorsCommitCount);
}

