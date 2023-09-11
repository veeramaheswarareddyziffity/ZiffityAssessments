<?php
namespace Task\CustomerFeedback\Block\Adminhtml;

use Magento\Framework\View\Element\Template;
use Task\CustomerFeedback\Model\FeedbackFactory;

class View extends Template
{
    protected $modelFactory;
   
    public function __construct(
        Template\Context $context,
        FeedbackFactory  $modelFactory,
      
        array $data = []
    ) {
        $this->modelFactory = $modelFactory;
        parent::__construct($context, $data);
    }

    
    public function getFeedbackData()
    {
        $id = $this->getRequest()->getParam('id');
        $data = $this->modelFactory->create()->load($id);
        // dd($data);
        return $data;

    }

    public function setAccept($id){

        return $this->getUrl('adminfeedback/index/accept',['id' => $id]);
    }
    public function setReject($id){
        
        return $this->getUrl('adminfeedback/index/reject',['id' => $id]);
    }
}