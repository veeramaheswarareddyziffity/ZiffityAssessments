<?php

namespace Ziffity\TrackingCart\Consumer;

use Magento\Framework\Serialize\SerializerInterface;
use Ziffity\TrackingCart\Model\TrackingProductFactory;
use Ziffity\TrackingCart\Model\ResourceModel\TrackingProduct as TrackingProductResource;
use Psr\Log\LoggerInterface;

/**
 * Class TrackingCart
 *
 * This class is responsible for consuming tracking data for a cart.
 *
 * @category Ziffity
 * @package  Ziffity\TrackingCart\Consumer
 */
class TrackingCart
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var TrackingProductFactory
     */
    protected $model;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var TrackingProductResource
     */
    private $resource;

    /**
     * TrackingCart constructor.
     *
     * @param SerializerInterface $serializer
     * @param TrackingProductFactory $model
     * @param LoggerInterface $logger
     */
    public function __construct(
        SerializerInterface $serializer,
        TrackingProductFactory $model,
        LoggerInterface $logger,
        TrackingProductResource $resource
    ) {
        $this->serializer = $serializer;
        $this->model = $model;
        $this->logger = $logger;
        $this->resource = $resource;
    }

    /**
     * Consume tracking data.
     *
     * @param string $data The tracking data to consume
     *
     * @return void
     */
    public function consume($data)
    {
        $model = $this->model->create();
        $unserializedData = $this->serializer->unserialize($data);

        try {
            $model->addData($unserializedData);
            $this->resource->save($model);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
