<?php
namespace Ziffity\TrackingCart\Api;

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
     * @return array[]
     */
    
    public function getApiData(int $pageId = null);

    /**
     * Save product data.
     *
     * @param string $sku
     * @param integer $quoteId
     * @param integer|null $customerId
     * @return void
     */
    public function save(string $sku, int $quoteId, int $customerId = null);

    /**
     * Get product data by SKU.
     *
     * @param string $sku
     * @return void
     */
    public function getBySku(string $sku);

    /**
     * Update product data.
     *
     * @param int      $id         The product ID
     * @param string   $sku        The SKU of the product
     * @param int      $quoteId    The quote ID
     * @param int|null $customerId The customer ID (optional)
     *
     * @return array[]
     */
    public function update(int $id, string $sku, 
        int $quoteId, int $customerId = null
    );

    /**
     * Delete product data by ID.
     *
     * @param int $id The product ID
     *
     * @return array[]
     */
    public function delete(int $id);
}
