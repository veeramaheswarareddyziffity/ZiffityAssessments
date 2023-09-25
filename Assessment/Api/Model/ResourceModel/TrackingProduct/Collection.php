<?php
namespace Assessment\Api\Model\ResourceModel\TrackingProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Assessment\Api\Model\TrackingProduct as TrackingProductModel;
use Assessment\Api\Model\ResourceModel\TrackingProduct as TrackingProductResourceModel;

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
