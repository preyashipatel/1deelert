<?php

namespace Elsnertech\Homeslider\Controller\Adminhtml\Homeslider;

class Index extends \Magento\Backend\App\Action
{
   
    protected $_resultPageFactory;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Elsnertech_Homeslider::Homeslider_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Desktop slider List'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elsnertech_Homeslider::Homeslider_list');
    }
}
