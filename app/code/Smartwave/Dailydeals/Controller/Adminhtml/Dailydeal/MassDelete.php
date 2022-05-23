<?php
namespace Smartwave\Dailydeals\Controller\Adminhtml\Dailydeal;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * $filter variable
     *
     * @var [type]
     */
    protected $filter;

    /**
     * $collectionFactory variable
     *
     * @var [type]
     */
    protected $collectionFactory;

    /**
     * constructor
     *
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Smartwave\Dailydeals\Model\ResourceModel\Dailydeal\CollectionFactory $collectionFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Smartwave\Dailydeals\Model\ResourceModel\Dailydeal\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
    
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $delete = 0;
        foreach ($collection as $item) {
            /** @var \Smartwave\Dailydeals\Model\Dailydeal $item */
            $item->delete();
            $delete++;
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $delete));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
