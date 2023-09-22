<?php

namespace Assessment\Api\Model\Api;

use Magento\Framework\DataObject;
use Assessment\Api\Api\ProductDataInterface;

class ProductData extends DataObject implements ProductDataInterface
{
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * @param int $id
     * @return $this
     */

    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * @return string
     */

    public function getSku()
    {
        return $this->getData('sku');
    }

    /**
     * @param string $sku
     * @return $this
     */

    public function setSku($sku)
    {
        return $this->setData('sku', $sku);
    }


    /**
     * @return int
     */

    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * @param string $customerid
     * @return $this
     */

    public function setCustomerId($customerid)
    {
        return $this->setData('customer_id', $customerid);
    }

    /**
     * @return int
     */

    public function getQuoteId()
    {
        return $this->getData('quote_id');
    }

    /**
     * @param string $quoteid
     * @return $this
     */

    public function setQuoteId($quoteid)
    {
        return $this->setData('quote_id', $quoteid);
    }


    /**
     * @return string
     */

    public function getCreated()
    {
        return $this->getData('created');
    }

    /**
     * @param string $created
     * @return $this
     */

    public function setCreated($created)
    {
        return $this->setData('created', $created);
    }

}
