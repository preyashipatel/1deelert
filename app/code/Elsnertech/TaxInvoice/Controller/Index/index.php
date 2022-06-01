<?php

namespace Elsnertech\TaxInvoice\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $_pageFactory;

/**
 * Undocumented function
 *
 * @param \Magento\Framework\App\Action\Context $context
 * @param \Magento\Framework\View\Result\PageFactory $pageFactory
 */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
