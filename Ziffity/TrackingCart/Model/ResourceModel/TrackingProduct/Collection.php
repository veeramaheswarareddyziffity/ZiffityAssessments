<?php

namespace Ziffity\TrackingCart\Model\ResourceModel\TrackingProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ziffity\TrackingCart\Model\TrackingProduct as TrackingProductModel;
use Ziffity\TrackingCart\Model\ResourceModel\TrackingProduct as TrackingProductResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Initialize the model.
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            TrackingProductModel::class,
            TrackingProductResourceModel::class
        );
    }
}
