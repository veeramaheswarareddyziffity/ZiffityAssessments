<?php

namespace Assessment\Api\Model\Api;

use Magento\Framework\DataObject;
use Assessment\Api\Api\ProductDataInterface;

/**
 * Class ProductData
 *
 * This class represents product data.
 *
 * @category Assessment
 * @package  Assessment\Api\Model\Api
 */
class ProductData extends DataObject implements ProductDataInterface
{
    /**
     * Get the product ID.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * Set the product ID.
     *
     * @param int $id The product ID
     *
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * Get the SKU (Stock Keeping Unit) of the product.
     *
     * @return string
     */
    public function getSku()
    {
        return $this->getData('sku');
    }

    /**
     * Set the SKU (Stock Keeping Unit) of the product.
     *
     * @param string $sku The SKU of the product
     *
     * @return $this
     */
    public function setSku($sku)
    {
        return $this->setData('sku', $sku);
    }

    /**
     * Get the customer ID associated with the product.
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * Set the customer ID associated with the product.
     *
     * @param int $customerId The customer ID associated with the product
     *
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }

    /**
     * Get the quote ID associated with the product.
     *
     * @return int
     */
    public function getQuoteId()
    {
        return $this->getData('quote_id');
    }

    /**
     * Set the quote ID associated with the product.
     *
     * @param string $quoteId The quote ID associated with the product
     *
     * @return $this
     */
    public function setQuoteId($quoteId)
    {
        return $this->setData('quote_id', $quoteId);
    }

    /**
     * Get the creation date of the product.
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->getData('created');
    }

    /**
     * Set the creation date of the product.
     *
     * @param string $created The creation date of the product
     *
     * @return $this
     */
    public function setCreated($created)
    {
        return $this->setData('created', $created);
    }
}
