<?php
namespace Ziffity\TrackingCart\Api;

/**
 * This interface defines methods for managing product data.
 *
 * @category Ziffity
 * @package  Ziffity\TrackingCart\Api
 */
interface ProductDataInterface
{
    /**
     * Get the product ID.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the product ID.
     *
     * @param  int $id The product ID
     * @return $this
     */
    public function setId($id);

    /**
     * Get the SKU of the product.
     *
     * @return string
     */
    public function getSku();

    /**
     * Set the SKU of the product.
     *
     * @param  string $sku The SKU of the product
     * @return $this
     */
    public function setSku($sku);

    /**
     * Get the quote ID associated with the product.
     *
     * @return int
     */
    public function getQuoteId();

    /**
     * Set the quote ID associated with the product.
     *
     * @param  int $quoteId 
     * @return $this
     */
    public function setQuoteId($quoteId);

    /**
     * Get the customer ID associated with the product.
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set the customer ID associated with the product.
     *
     * @param  int $customerId 
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get the creation date of the product.
     *
     * @return string
     */
    public function getCreated();

    /**
     * Set the creation date of the product.
     *
     * @param  string $created The creation date of the product
     * @return $this
     */
    public function setCreated($created);
}
