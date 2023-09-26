<?php

namespace Ziffity\TrackingCart\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TrackingProduct extends AbstractDb
{
    /**
     * Post Abstract Resource Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('customer_tracking_cart', 'id');
    }
}
