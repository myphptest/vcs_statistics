<?php

/**
 * Version Control Service (VCS) Statistics System API
 * This is the shared class among all VCS type to create the response
 * return from the executed curl request
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */

namespace lib\shared;

use lib\shared\message;
use lib\shared\exception;

/**
 * class to handle response
 */
class response {

    /**
     * Get a JSON response and transform it to a PHP array
     * 
     * @access protected
     * 
     * @param mixed $response   Curl Response
     * @param string $dataType  JSON/TEXT
     * 
     * @return  array   The response
     */
    protected function parseResponse($response, $dataType) {
        if ('text' === $dataType) {
            return $response;
        } elseif ('json' === $dataType) {
            return json_decode($response, true);
        }

        throw new exception(__CLASS__ . ' only supports json & text format, ' . $dataType . ' given.');
    }

    /**
     * This function shows the response of an API according to VCS statistics type
     * 
     * @access public
     * @param string $statistictype
     * @param mixed $response
     */
    public function showResponse($statistictype, $response) {

        switch ($statistictype) {
            case VCS_STATISTICS_TYPE_TOTAL_COMMIT:
                // to show the count of conributor commits
                if (!empty($response)) {
                    foreach ($response as $userName => $totalCount) {
                        echo "Contributor Name: " . $userName . " - Total no. of Commits:(" . $totalCount . ") " . PHP_EOL;
                    }
                } else {
                    echo message::RECORD_NOT_FOUND;
                }
                break;
            default :
                break;
        }
    }

}
