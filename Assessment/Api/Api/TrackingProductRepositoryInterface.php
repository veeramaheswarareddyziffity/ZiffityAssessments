<?php
namespace Assessment\Api\Api;

/**
 * This interface defines methods for tracking product repository operations.
 *
 * @category Assessment
 * @package  Assessment\Api\Api
 */
interface TrackingProductRepositoryInterface
{
    /**
     * Get API data.
     *
     * @param int|null $pageId The page ID (optional)
     *
     * @return \Assessment\Api\Api\ProductDataInterface[] An array of product data
     */
    public function getApiData(int $pageId = null);

    /**
     * Save product data.
     *
     * @param string   $sku        The SKU of the product
     * @param int      $quoteId    The quote ID
     * @param int|null $customerId The customer ID (optional)
     *
     * @return \Assessment\Api\Api.ProductDataInterface[] An array of product data
     */
    public function save(string $sku, int $quoteId, int $customerId = null);

    /**
     * Get product data by ID.
     *
     * @param int $id The product ID
     *
     * @return \Assessment\Api\Api.ProductDataInterface[] An array of product data
     */
    public function getById(int $id);

    /**
     * Update product data.
     *
     * @param int      $id         The product ID
     * @param string   $sku        The SKU of the product
     * @param int      $quoteId    The quote ID
     * @param int|null $customerId The customer ID (optional)
     *
     * @return \Assessment\Api\Api.ProductDataInterface[] An array of product data
     */
    public function update(int $id, string $sku, 
        int $quoteId, int $customerId = null
    );

    /**
     * Delete product data by ID.
     *
     * @param int $id The product ID
     *
     * @return \Assessment\Api\Api.ProductDataInterface[] An array of product data
     */
    public function delete(int $id);
}
