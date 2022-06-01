<?php
namespace Elsnertech\TaxInvoice\Model\ResourceModel\Invoice;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            \Elsnertech\TaxInvoice\Model\Invoice::class,
            \Elsnertech\TaxInvoice\Model\ResourceModel\Invoice::class
        );
    }
}
