<?php

namespace Ziffity\TrackingCart\Model\Api;

use Magento\Framework\Exception\LocalizedException;
use Ziffity\TrackingCart\Model\TrackingProductFactory as TrackingProductModel;
use Ziffity\TrackingCart\Model\ResourceModel\TrackingProduct as TrackingProductResource;
use Ziffity\TrackingCart\Model\ResourceModel\TrackingProduct\CollectionFactory;
use Ziffity\TrackingCart\Api\ProductDataInterfaceFactory;
use Ziffity\TrackingCart\Api\TrackingProductRepositoryInterface;

/**
 * Class TrackingProductRepository
 *
 * This class represents the repository for tracking products.
 *
 * @category Assessment
 * @package  Ziffity\TrackingCart\Model\Api
 */
class TrackingProductRepository implements TrackingProductRepositoryInterface
{
    /**
     * @var ProductDataInterfaceFactory
     */
    private $productDataInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var TrackingProductModel
     */
    private $model;

    /**
     * @var TrackingProductResource
     */
    private $resource;

    /**
     * Constructor.
     *
     * @param CollectionFactory           $collectionFactory 
     * @param ProductDataInterfaceFactory $productDataInterfaceFactory 
     * @param TrackingProductModel        $model 
     * @param TrackingProductResource     $resource 
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ProductDataInterfaceFactory $productDataInterfaceFactory,
        TrackingProductModel $model,
        TrackingProductResource $resource
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->productDataInterfaceFactory = $productDataInterfaceFactory;
        $this->model = $model;
        $this->resource = $resource;
    }

    /**
     * @param  int|null $pageId
     * @return \Ziffity\TrackingCart\Api\ProductDataInterface[]
     */
    public function getApiData(int $pageId = null)
    {
        if ($pageId === null) {
            $pageId = 1;
        }
        $data = [];

        try {
            $collection = $this->collectionFactory->create()
                ->setPageSize(10)->setCurPage($pageId);

            foreach ($collection as $item) {
                $Productdata = [
                    'id' => $item->getId(),
                    'sku' => $item->getSku(),
                    'quote_id' => $item->getQuoteId(),
                    'customer_id' => $item->getCustomerId(),
                    'created_at' => $item->getCreated(),
                ];
                $data[] = $Productdata;
            }

            return $data;
        } catch (LocalizedException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * @param  string   $sku 
     * @param  int      $quoteId 
     * @param  int|null $customerId 
     * @return array
     */
    public function save(string $sku, int $quoteId, int $customerId = null)
    {
        $model = $this->model->create();
        $model->setSku($sku);
        $model->setQuoteId($quoteId);
        $model->setCustomerId($customerId);

        try {
            $this->resource->save($model);
            $response = ['success' => 'Saved Successfully'];
            return $response;
        } catch (LocalizedException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * get the product data from sku
     *
     * @param string $sku
     * @return array
     */
    public function getBySku(string $sku)
    {
        try {
            if ($sku) {
                $collection = $this->collectionFactory->create();
                $data = $collection->addFieldToFilter('sku', $sku)->getData();
                return $data;
            }
        } catch (LocalizedException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * @param  int      $id 
     * @param  string   $sku 
     * @param  int|null $quoteId 
     * @param  int|null $customerId 
     * @return array
     */
    public function update(
        int $id,
        string $sku,
        int $quoteId = null,
        int $customerId = null
    ) {
        $model = $this->model->create();
        $this->resource->load($model, $id, 'id');
        if (!$model->getData()) {
            return ['success' => 'ID is not Available'];
        }
        if ($sku) {
            $model->setSku($sku);
        }

        if ($quoteId) {
            $model->setQuoteId($quoteId);
        }

        if ($customerId) {
            $model->setCustomerId($customerId);
        }

        try {
            $this->resource->save($model);
            return ['success' => 'Updated Successfully'];
        } catch (LocalizedException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * @param  int $id 
     * @return array
     */
    public function delete(int $id)
    {
        try {
            $model = $this->model->create();
            $this->resource->load($model, $id, 'id');

            if (!$model->getData()) {
                return ['success' => 'ID is not Available'];
            }
            $this->resource->delete($model);
            return ['success' => true, 'message' => "Deleted Successfully"];
        } catch (LocalizedException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
