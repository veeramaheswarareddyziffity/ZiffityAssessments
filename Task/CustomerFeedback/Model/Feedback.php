<?php

namespace Task\CustomerFeedback\Model;


use Magento\Framework\Model\AbstractModel;
use Task\CustomerFeedback\Model\ResourceModel\Feedback as ResourceModel;

class Feedback extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);

    }

}
