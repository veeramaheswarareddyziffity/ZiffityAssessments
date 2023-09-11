<?php

namespace Task\CustomerFeedback\Model\ResourceModel\Feedback;

use Task\CustomerFeedback\Model\Feedback as Feedback;
use Task\CustomerFeedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Feedback::class, FeedbackResourceModel::class);
    }
}
