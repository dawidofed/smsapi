<?php
/**
 * Studio IT
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the federowicz.net license that is
 * available through the world-wide-web at this URL:
 * http://www.federowicz.net/M2LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    StudioIt
 * @package     StudioIt_Smsapi
 * @copyright   Copyright (c) Studio IT Dawid Federowicz (http://www.federowicz.net/)
 * @license     http://www.federowicz.net/M2LICENSE.txt
 */

namespace StudioIt\Smsapi\Logger;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class LogWrite
{

    protected $_message;

    const ERROR = 'ERROR';
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';

    /**
     * @param $message
     * @param $logLevel
     */
    public function write($message, $logLevel)
    {
        $writer = new Stream(BP . '/var/log/smsapi.log');
        $logger = new Logger();
        $logger->addWriter($writer);
        if ($logLevel === self::ERROR) {
            $logger->err($message);
        } elseif ($logLevel === self::DEBUG) {
            $logger->debug($message);
        } else {
            $logger->info($message);
        }
    }

}