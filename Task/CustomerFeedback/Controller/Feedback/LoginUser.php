<?php
namespace Task\CustomerFeedback\Controller\Feedback;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;


class LoginUser extends Action
{

    protected $customerSession;

    public function __construct(
        Context $context,
        Session $customerSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
    }


    public function execute()
    {
        if($this->customerSession->isLoggedIn()){
            
            $this->_view->loadLayout();
            $this->_view->renderLayout();
            
        }
        else{
            $this->_redirect('feedback/feedback/index');
        }
    }
}