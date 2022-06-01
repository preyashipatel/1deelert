<?php

namespace Elsnertech\PaySlip\Model\ResourceModel\PaySlip;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Elsnertech\PaySlip\Model\PaySlip',
            'Elsnertech\PaySlip\Model\ResourceModel\PaySlip'
        );
    }
}