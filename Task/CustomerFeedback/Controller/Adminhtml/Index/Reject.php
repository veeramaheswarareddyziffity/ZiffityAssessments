<?php

namespace Task\CustomerFeedback\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\Action ;
use Magento\Framework\App\Action\Context ;
use Task\CustomerFeedback\Model\FeedbackFactory as ModelFactory;
use Task\CustomerFeedback\Model\ResourceModel\Feedback as FeedbackResourceModel ;
use Task\CustomerFeedback\Helper\Mail ; 


class Reject extends Action {

    protected $modelFactory;

    protected $feedbackResourceModel;

    protected $helperMail;

    public function __construct(
        Context $context,
        ModelFactory $modelFactory ,
        Mail $helperMail,
        FeedbackResourceModel $feedbackResourceModel)
    {
        parent::__construct($context);
        $this->modelFactory = $modelFactory;
        $this->feedbackResourceModel = $feedbackResourceModel;
        $this->helperMail = $helperMail;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $data = [
            'status' => 'Rejected'
        ];
        // dd($id);
        $templateId = "email_reject_template";
        // dd($id);
        $feedbackData = $this->modelFactory->create();
         $getData = $this->feedbackResourceModel->load($feedbackData,$id);

        if($getData){
            $feedbackData->addData($data);
            $firstname =$feedbackData->getData('firstName');
            $lastname =$feedbackData->getData('lastName');
            $customerName =$firstname." ".$lastname;
            $email = $feedbackData->getEmail();
            $recipientType = "";
            try{
                $getData->save($feedbackData);
                $this->helperMail->sendEmail($email,$customerName,$templateId,$recipientType);
     
                $this->messageManager->addSuccessMessage(__("Feedback is Rejected"));
                $redirect = $this->resultRedirectFactory->create();
                $redirect->setPath('adminfeedback/index/index');
                return $redirect;
             }
             catch(\Exception $e){
                $this->messageManager->addErrorMessage(__("Somthing Went Wrong"));
                $redirect = $this->resultRedirectFactory->create();
                $redirect->setPath('adminfeedback/index/index');
                return $redirect;
             }
        }
    }
}