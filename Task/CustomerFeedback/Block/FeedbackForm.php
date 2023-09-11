<?php

namespace Task\CustomerFeedback\Block;

use Magento\Framework\View\Element\Template;
// use Task\CustomerFeeedback\Model\FeedabackFactory;
// use  Task\CustomerFeedback\Model\ResourceModel\Feedback\CollectionFactory;


class FeedbackForm extends Template
{

    // private $collectionFactory;

    protected $feedbackFactory;

    /**
     * Display constructor.
     * @param Template\Context $context
     * @param Collection $collection
     * @param array $data
     */

    public function __construct(
        Template\Context $context,
        // FeedbackFactory $feedbackFactory,

        // CollectionFactory $collectionFactory,

        // array $data = [],

    ) {
        // $this->collectionFactory = $collectionFactory;
        // $this->feedbackFactory = $feedbackFactory;
        parent::__construct($context);
    }

    public function getFormAction()
    {
        return $this->getUrl('feedback/feedback/save');
    }

    // public function getApprovedFeedback()
    // {
    //     $feedbackCollection = $this->feedbackFactory->create()->getCollection();
    //     // $feedbackCollection = $this->collectionFactory->create();
    //     $feedbackData = $feedbackCollection->addFieldToFilter('status', 'Accepted');
    //     if ($feedbackData) {
    //         return $feedbackData;
    //     }
    //     return null;
    // }
}
