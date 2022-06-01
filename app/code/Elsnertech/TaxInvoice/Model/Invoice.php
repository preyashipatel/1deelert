<?php
namespace Elsnertech\TaxInvoice\Model;

use Magento\Framework\Model\AbstractModel;

class Invoice extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Elsnertech\TaxInvoice\Model\ResourceModel\Invoice::class);
    }
}
