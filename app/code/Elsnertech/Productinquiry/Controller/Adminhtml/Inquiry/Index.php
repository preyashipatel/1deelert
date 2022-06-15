<?php

namespace Elsnertech\Productinquiry\Controller\Adminhtml\inquiry;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Undocumented variable
     *
     * @var boolean
     */
    protected $resultPageFactory = false;

    /**
     * Undocumented function
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Product Inquiey')));

        return $resultPage;
    }
}
