<?php
declare(strict_types=1);

namespace Studioit\Smsapi\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Model\AbstractModel;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use StudioIt\Smsapi\Gateway\SendSms;
use StudioIt\Smsapi\Helper\Configs;
use StudioIt\Smsapi\Helper\SmsValidate;
use StudioIt\Smsapi\Logger\LogWrite;
use Magento\Framework\Logger\Monolog;

class ChangeStatusOrder extends AbstractDataAssignObserver
{

    private $scopeConfig;
    private $order;
    private $logger;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Monolog $logger
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $logWrite = new LogWrite();

        $this->logger->info('=== Start SMSAPI ===');
        $config = new Configs($this->_scopeConfig);
        if (false === $config->isEnabled()) {
            $logWrite->write('SMSAPI disabled.', $logWrite::INFO);
            $logWrite->write('=== Finish SMSAPI ===', $logWrite::INFO);

            return false;
        }

        $phoneNumber = $observer->getOrder()->getBillingAddress()->getTelephone();
        $order = $observer->getEvent()->getOrder();
        if ($order instanceof AbstractModel) {

            // validate
            $smsValidate = new SmsValidate();
            if (false === $smsValidate->validate($phoneNumber)) {
                $logWrite->write('Wrong phone number, or message is empty.', $logWrite::ERROR);
                $logWrite->write('=== Finish SMSAPI ===', $logWrite::INFO);

                return false;
            }

            // check if SMS enabled for this status
            if (false === $config->getConfigStatus($order->getState())) {
                $logWrite->write('SMSAPI disabled for status ' . $order->getState(), $logWrite::INFO);
                $logWrite->write('=== Finish SMSAPI ===', $logWrite::INFO);

                return false;
            }

            // check if text for this status is empty
            if (false === $config->getText($order->getState())) {
                $logWrite->write('Text for status ' . $order->getState() . ' is empty!', $logWrite::ERROR);
                $logWrite->write('=== Finish SMSAPI ===', $logWrite::INFO);

                return false;
            }

            $sendSms = new SendSms();
            $message = str_replace('%orderId%', $order->getId(), $config->getText($order->getState()));

            // check if SMS sended properly
            if (false === $sendSms->createAndSendSmS($phoneNumber, $message, $config->getApiToken())) {
                $logWrite->write('SMS NOT sended - error. Check in smsapi.log log file.', $logWrite::ERROR);
            } else {
                $logWrite->write('SMS sended (' . $phoneNumber . ' :: ' . $config->getText($order->getState()) . ')', $logWrite::INFO);
            }
            $logWrite->write('=== Finish SMSAPI ===', $logWrite::INFO);
        }
    }
}
