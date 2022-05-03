<?php

namespace Elsnertech\Homeslider\Model\ResourceModel\Homeslider;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Elsnertech\Homeslider\Model\Homeslider', 'Elsnertech\Homeslider\Model\ResourceModel\Homeslider');
    }
}
