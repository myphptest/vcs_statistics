<?php

/**
 * Version Control Service (VCS) Statistics System API
 * Exception class file
 * 
 * @package vcs_statistics
 * @author Nishu Rani <nishurajvanshi27@gmail.com>
 */

namespace lib\shared;

/**
 * Creating a user defined exception class
 * to show error message with error code
 */
class exception extends \Exception {

    /**
     * to show error message
     * 
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct($errMessage, $errCode = 0) {

        $errMsg = '';
        $errMsg .= 'ERROR: ' . $errMessage;
        if (!empty($errCode)) {
            $errMsg .= ', ERROR CODE: ' . $errCode;
        }
        echo $errMsg;
    }

}
