<?php

namespace Assessment\Api\Consumer;

use Magento\Framework\Serialize\SerializerInterface;
use Assessment\Api\Model\TrackingProductFactory;

/**
 * Class TrackingCart
 *
 * This class is responsible for consuming tracking data for a cart.
 *
 * @category Assessment
 * @package  Assessment\Api\Consumer
 */
class TrackingCart
{
    protected $serializer;
    protected $model;

    /**
     * TrackingCart constructor.
     *
     * @param SerializerInterface    $serializer The serializer
     * @param TrackingProductFactory $model      The tracking product factory
     */
    public function __construct(
        SerializerInterface $serializer,
        TrackingProductFactory $model
    ) {
        $this->serializer = $serializer;
        $this->model = $model;
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
            $model->addData($unserializedData)->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
