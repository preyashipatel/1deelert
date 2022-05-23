<?php

namespace Elsnertech\Homeslider\Controller\Adminhtml\Homeslider;

class Index extends \Magento\Backend\App\Action
{

    /**
     * $_resultPageFactory variable
     *
     * @var [type]
     */
    protected $_resultPageFactory;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * Comment of execute function
     *
     * @return void
     */
    public function execute()
    {
        /**
         * Comment
         *
         * @var \Magento\Backend\Model\View\Result\Page $resultPage
         */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Elsnertech_Homeslider::Homeslider_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Desktop slider List'));

        return $resultPage;
    }

    /**
     * Comment of _isAllowed function
     *
     * @return void
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elsnertech_Homeslider::Homeslider_list');
    }
}
