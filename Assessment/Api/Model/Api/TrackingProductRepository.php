<?php
namespace Assessment\Api\Model\Api;
use Magento\Framework\Exception\LocalizedException;
use Assessment\Api\Model\TrackingProductFactory as TrackingProductModel;
use Assessment\Api\Model\ResourceModel\TrackingProduct as TrackingProductResource;
use Assessment\Api\Model\ResourceModel\TrackingProduct\CollectionFactory;
use Assessment\Api\Api\ProductDataInterfaceFactory;
use Assessment\Api\Api\TrackingProductRepositoryInterface;

class TrackingProductRepository implements  TrackingProductRepositoryInterface
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
     * @return \Assessment\Api\Api\ProductDataInterface[]
     */
    public function getApiData(int $pageId = null)
    {
        if ($pageId == null) {
            $pageId = 1;
        }
        $data=[];

        try {
                $collection = $this->collectionFactory->create()->setPageSize(10)->setCurPage($pageId);

            foreach ($collection as $item) {
                $data1=['id'=>$item->getId(),
                'sku'=>$item->getSku(),
                'quote_id'=>$item->getQuoteId(),
                'customer_id'=>$item->getCustomerId(),
                'created_at'=>$item->getCreated()

            ];
                $data[]=$data1;
            }

                return $data;


        } catch (LocalizedException $e) {
            throw $e;
        }

    }


     /**
      * @param  string $sku
      * @param  int    $quoteId
      * @param  int    $customerId
      * @return \Assessment\Api\Api\ProductDataInterface[]
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
            throw $e;
        }

    }


     /**
      * @param  int $id
      * @return \Assessment\Api\Api\ProductDataInterface[]
      */

    public function getById(int $id)
    {
        try {
            if ($id) {
                $model = $this->model->create();
                $this->resource->load($model, $id, 'id');
                return $data = $model->getData();

            }
        } catch (LocalizedException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

    }



     /**
      * @param  string $id
      * @param  string $sku
      * @param  int    $quoteId
      * @param  int    $customerId
      * @return \Assessment\Api\Api\ProductDataInterface[]
      */
    public function update(int $id, string $sku , int $quoteId = null, int $customerId = null )
    {


        $model = $this->model->create();
        $this->resource->load($model, $id, 'id');
        if(!$model->getData()) {
            return ['success' => 'ID is not Available'];
        }
        if ($sku != null) {
            $model->setSku($sku);
        }

        if ($quoteId != null) {
            $model->setQuoteId($quoteId);
        }

        if ($customerId != null) {
            $model->setCustomerId($customerId);
        }


        try {
            $this->resource->save($model);
            return ['success' => 'Updated Successfully'];
        } catch (LocalizedException $e) {
            throw $e;
        }





    }


    /**
     * @param  string $id
     * @return \Assessment\Api\Api\DataInterface
     */


    public function delete(int $id)
    {
        $model = $this->model->create();
        $this->resource->load($model, $id, 'id');

        if(!$model->getData()) {
            return ['success' => 'ID is not Available'];
        }
        try {

                $this->resource->delete($model);
                return ['success' => true, 'message' => "Deleted Successfully"];

        } catch (LocalizedException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}