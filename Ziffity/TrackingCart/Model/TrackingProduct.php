<?php

namespace Ziffity\TrackingCart\Model;

use Magento\Framework\Model\AbstractModel;
use Ziffity\TrackingCart\Model\ResourceModel\TrackingProduct as TrackingProductResourceModel;

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
