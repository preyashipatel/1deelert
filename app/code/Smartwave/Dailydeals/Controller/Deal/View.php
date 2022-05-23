<?php
namespace Smartwave\Dailydeals\Controller\Deal;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class View extends \Magento\Framework\App\Action\Action
{
    /**
     * $pageFactory variable
     *
     * @var [type]
     */
    protected $pageFactory;
    /**
     * $resultRedirectFactory variable
     *
     * @var [type]
     */
    protected $resultRedirectFactory;
    /**
     * $scopeConfig variable
     *
     * @var [type]
     */
    protected $scopeConfig;
    /**
     * Comment of __construct function
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
    
        $this->pageFactory = $pageFactory;
        $this->resultRedirectFactory=$resultRedirectFactory;
        $this->scopeConfig=$scopeConfig;
        
        return parent::__construct($context);
    }

    /**
     * Comment of execute function
     *
     * @return void
     */
    public function execute()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
     
              $page_object = $this->pageFactory->create();
              return $page_object;
    }
}
