<?php
namespace Elsnertech\Productinquiry\Model\ResourceModel;

class Inquiry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('product_inquiry', 'id');
    }
}
