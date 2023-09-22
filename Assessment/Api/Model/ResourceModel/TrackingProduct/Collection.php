<?php
namespace Assessment\Api\Model\ResourceModel\TrackingProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    

    protected function _construct()
{
    $this->_init(
        \Assessment\Api\Model\TrackingProduct::class,
        \Assessment\Api\Model\ResourceModel\TrackingProduct::class
    );
}

}
