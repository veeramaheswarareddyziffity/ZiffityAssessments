<?php
namespace Assessment\Api\Api;

interface TrackingProductRepositoryInterface
{
   /**
     * @param int|null $pageId
     * @return \Assessment\Api\Api\ProductDataInterface[]
     */
    public function getApiData(int $pageId = null);


   /**
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     *  @return \Assessment\Api\Api\ProductDataInterface[]
     */
    public function save(string $sku, int $quoteId, int $customerId = null);


  /**
     * @param int $id
     * @return \Assessment\Api\Api\ProductDataInterface[]
     */
    public function getById(int $id);

     /**
     * @param string $id
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @return \Assessment\Api\Api\ProductDataInterface[]
     */
    public function update(int $id, string $sku, int $quoteId, int $customerId = null);

  /**
     * @param string $id
     * @return \Assessment\Api\Api\ProductDataInterface[]
     */

    public function delete(int $id);
}