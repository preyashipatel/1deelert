<?php
namespace Smartwave\Dailydeals\Controller\Adminhtml;

abstract class Dailydeal extends \Magento\Backend\App\Action
{
    /**
     * $dailydealFactory variable
     *
     * @var [type]
     */
    protected $dailydealFactory;

    /**
     * $coreRegistry variable
     *
     * @var [type]
     */
    protected $coreRegistry;
    /**
     * $resultRedirectFactory variable
     *
     * @var [type]
     */
    protected $resultRedirectFactory;

    /**
     * Comment of __construct function
     *
     * @param \Smartwave\Dailydeals\Model\DailydealFactory $dailydealFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Smartwave\Dailydeals\Model\DailydealFactory $dailydealFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
    
        $this->dailydealFactory      = $dailydealFactory;
        $this->coreRegistry          = $coreRegistry;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        parent::__construct($context);
    }

    /**
     * Init Dailydeal
     *
     * @return \Smartwave\Dailydeals\Model\Dailydeal
     */
    protected function initDailydeal()
    {
        $dailydealId  = (int) $this->getRequest()->getParam('dailydeal_id');
        /** @var \Smartwave\Dailydeals\Model\Dailydeal $dailydeal */
        $dailydeal    = $this->dailydealFactory->create();
        if ($dailydealId) {
            $dailydeal->load($dailydealId);
        }
        $this->coreRegistry->register('sw_dailydeals_dailydeal', $dailydeal);
        return $dailydeal;
    }
}
