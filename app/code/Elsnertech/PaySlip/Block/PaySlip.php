<?php

namespace Elsnertech\PaySlip\Block;

class PaySlip extends \Magento\Framework\View\Element\Template
{
    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        parent::__construct($context);
       }

       public function _prepareLayout()
       {
           return parent::_prepareLayout();
       }
}