<?php
namespace Elsnertech\TaxInvoice\Model\ResourceModel;

class Invoice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('tax_invoice', 'id');
    }
}
