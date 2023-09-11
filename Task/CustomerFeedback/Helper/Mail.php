<?php

namespace Task\CustomerFeedback\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Mail extends AbstractHelper
{
    protected $transportBuilder;
    protected $storeManager;
    protected $inlineTranslation;
    protected $scopeConfig;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        StateInterface $state
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function sendEmail($customerEmail, $customerName, $templateId, $recipientType)
    {
        $this->inlineTranslation->suspend();
        $senderEmail = 'support@example.com';
        $senderName = 'Admin';
        $subject = 'Hey,Your Feedback Status';
        // dd($customerEmail,$customerName,$templateId);
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $storeId = $this->storeManager->getStore()->getId();
        $sender = ['email' => $senderEmail, 'name' => $senderName];
        

        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
            'store' => $storeId
        ];
        $storeAdminEmail = $this->scopeConfig->getValue(
            'trans_email/ident_general/email',
            $storeScope,
            $storeId
        );
       
        $transport = $this->transportBuilder->setTemplateIdentifier(
            $templateId,
            $storeScope
        )
            // ->setSubject('Your Form Submission')
            
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars(['customer_name' => $customerName])
            ->setFrom($sender)
            ->addTo([$customerEmail, $customerName])
            ->getTransport();

            // dd($storeId);

        // dd($transport);
        $transport->getMessage()->setSubject($subject);
        if ($recipientType === 'customer') {
            // dd($recipientType);
            $transport->getMessage()->addBcc($storeAdminEmail);
        }
        // dd($storeId);
        try {
            
            
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->error($e->getMessage());
        }
    }
}
