<?php

namespace Elsnertech\TaxInvoice\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;

class TaxInvoiceForm extends Template
{
    /**
     * Undocumented function
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    // public function getFormAction()
    // {
    //     return $this->getUrl('taxinvoice/index/save', ['_secure' => true]);
    // }
}
