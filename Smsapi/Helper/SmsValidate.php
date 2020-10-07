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

namespace StudioIt\Smsapi\Helper;


class SmsValidate
{
    /**
     * @param $phoneNumber
     * @return bool
     */
    public function validate($phoneNumber)
    {
        if (false === $this->_validatePhoneNumber($phoneNumber)) {
            return false;
        }
        return true;
    }

    /**
     * @param $phoneNumber
     * @return bool|string
     */
    private function _validatePhoneNumber($phoneNumber)
    {
        $phoneNumber = trim($phoneNumber);

        if (strlen($phoneNumber) === 9) {
            return $phoneNumber;
        }
        if (substr($phoneNumber, 0, 1) === '+'
            && substr($phoneNumber, 0, 3) === '+48'
            && strlen(substr($phoneNumber, 3)) === 9) {
            return substr($phoneNumber, 3);
        }
        return false;
    }
}