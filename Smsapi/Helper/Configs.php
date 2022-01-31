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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ScopeInterface;

class Configs
{
    protected $_scopeConfig;

    const PRE = 'studioit/smsapi/';

    const smsApiEnabled = 'smsApiEnabled';
    const smsApiToken = 'apiToken';
    const statusNEW = 'new';
    const statusCANCELED = 'canceled';
    const statusHOLDED = 'holded';
    const statusCOMPLETE = 'complete';

    /**
     * Configs constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        if (null !== $this->_scopeConfig->getValue(self::PRE . self::smsApiEnabled, ScopeInterface::SCOPE_DEFAULT)
            && $this->_scopeConfig->getValue(self::PRE . self::smsApiEnabled, ScopeInterface::SCOPE_DEFAULT) !== '') {

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getApiToken()
    {
        if (null !== $this->_scopeConfig->getValue(self::PRE . self::smsApiToken, ScopeInterface::SCOPE_DEFAULT)
            && $this->_scopeConfig->getValue(self::PRE . self::smsApiToken, ScopeInterface::SCOPE_DEFAULT) !== '') {

            return true;
        }

        return false;
    }

    /**
     * @param $status
     * @return bool
     */
    public function getConfigStatus($status)
    {
        if (null !== $this->_scopeConfig->getValue(self::PRE . 'status' . ucfirst($status), ScopeInterface::SCOPE_DEFAULT)
            && $this->_scopeConfig->getValue(self::PRE . 'status' . ucfirst($status), ScopeInterface::SCOPE_DEFAULT) !== ''
            && $this->_scopeConfig->getValue(self::PRE . 'status' . ucfirst($status), ScopeInterface::SCOPE_DEFAULT) !== '0') {

            return $this->_scopeConfig->getValue(self::PRE . 'status' . ucfirst($status), ScopeInterface::SCOPE_DEFAULT);
        }

        return false;
    }

    /**
     * @param $status
     * @return bool
     */
    public function getText($status)
    {
        if (null !== $this->_scopeConfig->getValue(self::PRE . 'status' . ucfirst($status) . 'Text', ScopeInterface::SCOPE_DEFAULT)
            && $this->_scopeConfig->getValue(self::PRE . 'status' . ucfirst($status) . 'Text', ScopeInterface::SCOPE_DEFAULT) !== '') {

            return $this->_scopeConfig->getValue(self::PRE . 'status' . ucfirst($status) . 'Text', ScopeInterface::SCOPE_DEFAULT);
        }

        return false;
    }
}
