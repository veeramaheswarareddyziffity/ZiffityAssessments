<?php
namespace Task\CustomerFeedback\Controller\Feedback;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Task\CustomerFeedback\Model\FeedbackFactory;
use Magento\Framework\App\Action\Action;

class Scroller extends Action
{
    protected $resultPageFactory;
    protected $feedbackFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        FeedbackFactory $feedbackFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->feedbackFactory = $feedbackFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Fetch data from the database using your model
        // $feedbackCollection = $this->feedbackFactory->create()->getCollection();
        // $feedbackCollection->addFieldToFilter('status', 'Accepted');
        
        // // Display the data using dd()
        // return $feedbackCollection->getData();
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        // You can also return a blank result page or redirect if needed
    }
}
