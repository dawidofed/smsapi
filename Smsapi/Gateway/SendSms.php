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

namespace StudioIt\Smsapi\Gateway;

use Smsapi\Client\SmsapiClientException;

use Smsapi\Client\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use StudioIt\Smsapi\Logger\LogWrite;

class SendSms
{

    public function createAndSendSmS($phoneNumber, $message, $apiToken)
    {
        $writeLog = new LogWrite();
        try {
            $sms = SendSmsBag::withMessage($phoneNumber, $message);
            $service = (new SmsapiHttpClient())->smsapiComService($apiToken);
            $send = $service->smsFeature()->sendSms($sms);
            $writeLog->write('Status: ' . $send->status, $writeLog::INFO);

            return true;
        } catch (SmsapiClientException $smsapiClientException) {
            $writeLog->write('ERROR in createAndSendSms: ' . $smsapiClientException, $writeLog::ERROR);

            return false;
        }
    }

}
