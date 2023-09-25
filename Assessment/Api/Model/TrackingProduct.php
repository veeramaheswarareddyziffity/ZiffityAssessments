<?php

namespace Assessment\Api\Model;

use Magento\Framework\Model\AbstractModel;
use Assessment\Api\Model\ResourceModel\TrackingProduct as TrackingProductResourceModel; 

class TrackingProduct extends AbstractModel
{
    /**
     * Initialize the model.
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TrackingProductResourceModel::class); 
    }
}
