<?php

namespace Task\CustomerFeedback\Controller\Feedback;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Task\CustomerFeedback\Model\Feedback as FeedbackModel;
use Task\CustomerFeedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Magento\Customer\Model\Session;
use Task\CustomerFeedback\Helper\Mail;

class Save extends Action
{

    protected  $customerSession;

    protected $feedbackModel;

    protected $feedbackResourceModel;
    protected $mailHelper;

     /**
     * Add constructor.
     * @param Context $context
     * @param FeedbackModel $feedbackModel
     * @param FeedbackResourceModel $feedbackResourceModel
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        FeedbackModel $feedbackModel,
        FeedbackResourceModel $feedbackResourceModel,
        Session $customerSession,
        Mail $mailHelper
    ) {
        $this->feedbackModel = $feedbackModel;
        $this->feedbackResourceModel = $feedbackResourceModel;
        $this->customerSession = $customerSession;
        $this->mailHelper = $mailHelper;
        parent::__construct($context);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $customerTemplateId = "email_save_template";
        
        if($this->customerSession->isLoggedIn()){

            $customer = $this->customerSession->getCustomer();
            $firstname = $customer->getFirstname();
            $lastname = $customer->getLastname();
            $email = $customer->getEmail();
            

            $customerFeedback = $params['feedback'];

            $data = [
                'firstName'=> $firstname,
                'lastName'=> $lastname,
                'email'=> $email,
                'feedback'=> $customerFeedback
            ];
            $saving = $this->feedbackModel->setData($data);
            try {
                
                $this->feedbackResourceModel->save($saving);
                
                
                $this->mailHelper->sendEmail($email, $firstname, $customerTemplateId, 'customer');
                // $this->mailHelper->sendEmail($email, $firstname, $adminTemplateId, 'admin');

                $this->messageManager->addSuccessMessage(__("Feedback is Submitted"));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__("Something went wrong."));
            }
            /* Redirect back to hero display page */
            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath('');
            return $redirect;


        }

        else {
            $data =[
                'firstName'=>$params['first_name'],
                'lastName'=>$params['last_name'],
                'email'=>$params['email'],
                'feedback'=>$params['feedback']
            ];
            $saving = $this->feedbackModel->setData($data);//TODO: Challenge Modify here to support the edit save functionality
            try {
                
                $this->feedbackResourceModel->save($saving);
                // $this->mailHelper->sendEmail($params['email'], $params['first_name'], $customerTemplateId, 'customer');
        
                $this->mailHelper->sendEmail($params['email'], $params['first_name'],$customerTemplateId , 'customer');
                $this->messageManager->addSuccessMessage(__("Feedback is Submitted"));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }

            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath('');
            return $redirect;
        }
    }

}