<?php
namespace Elsnertech\Productinquiry\Model\ResourceModel\Inquiry;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            \Elsnertech\Productinquiry\Model\Inquiry::class,
            \Elsnertech\Productinquiry\Model\ResourceModel\Inquiry::class
        );
    }
}
