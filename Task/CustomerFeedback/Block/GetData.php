<?php

namespace Task\CustomerFeedback\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Request\Http;
use Task\CustomerFeedback\Model\ResourceModel\Feedback\CollectionFactory;

class GetData extends Template
{
    protected $feedbackCollectionFactory;
    protected $request;

    public function __construct(
        Template\Context $context,
        CollectionFactory $feedbackCollectionFactory,
        Http $request,
        array $data = []
    ) {
        $this->feedbackCollectionFactory = $feedbackCollectionFactory;
        $this->request = $request;
        parent::__construct($context, $data);

    }


    public function getApprovedFeedback()
    {
        // Retrieve approved feedback records from the collection
        $feedbackCollection = $this->feedbackCollectionFactory->create();
        $feedbackCollection->addFieldToFilter('status', 'Accepted');
        

        return $feedbackCollection;
    }

    public function isHomepage()
    {
        $fullActionName = $this->request->getFullActionName();
        // $requestPath = trim($this->request->getPathInfo(), '/');

        return ($fullActionName == 'cms_index_index');
    }
    }

