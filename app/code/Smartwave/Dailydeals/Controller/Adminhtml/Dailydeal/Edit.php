<?php
namespace Smartwave\Dailydeals\Controller\Adminhtml\Dailydeal;

class Edit extends \Smartwave\Dailydeals\Controller\Adminhtml\Dailydeal
{

    /**
     * $backendSession variable
     *
     * @var [type]
     */
    protected $backendSession;

    /**
     * Page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * $resultJsonFactory variable
     *
     * @var [type]
     */
    protected $resultJsonFactory;
    /**
     * Comment of __construct function
     *
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Smartwave\Dailydeals\Model\DailydealFactory $dailydealFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Smartwave\Dailydeals\Model\DailydealFactory $dailydealFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    ) {
    
        $this->backendSession    = $context->getSession();
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($dailydealFactory, $registry, $context);
    }

    /**
     * Is action allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smartwave_Dailydeals::dailydeal');
    }

    /**
     * Comment of execut function
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('dailydeal_id');
        /** @var \Smartwave\Dailydeals\Model\Dailydeal $dailydeal */
        $dailydeal = $this->initDailydeal();
        /** @var \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smartwave_Dailydeals::dailydeal');
        $resultPage->getConfig()->getTitle()->set(__('Dailydeals'));
        if ($id) {
            $dailydeal->load($id);
            if (!$dailydeal->getId()) {
                $this->messageManager->addError(__('This Dailydeal no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath(
                    'sw_dailydeals/*/edit',
                    [
                        'dailydeal_id' => $dailydeal->getId(),
                        '_current' => true
                    ]
                );
                return $resultRedirect;
            }
        }
        $title = $dailydeal->getId() ? $dailydeal->getSw_product_sku() : __('New Dailydeal');
        $resultPage->getConfig()->getTitle()->prepend($title);
        $data = $this->backendSession->getData('sw_dailydeals_dailydeal_data', true);
        if (!empty($data)) {
            $dailydeal->setData($data);
        }
        return $resultPage;
    }
}
