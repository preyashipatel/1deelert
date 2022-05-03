<?php

namespace Elsnertech\Flashsale\Model\ResourceModel\FlashsaleProduct;
 
class CollectionFactory
{

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;
 
    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Elsnertech\Flashsale\Model\ResourceModel\FlashsaleProduct\Collection $instanceName)
    {
        $this->_instanceName = $instanceName;
    }
 
    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Elsnertech\Flashsale\\Model\ResourceModel\FlashsaleProduct\Collection
     */
    public function create(array $data = [])
    {
        return $this->_instanceName;
    }
}
