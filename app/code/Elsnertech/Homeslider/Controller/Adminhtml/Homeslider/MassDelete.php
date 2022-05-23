<?php

namespace Elsnertech\Homeslider\Controller\Adminhtml\Homeslider;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Elsnertech\Homeslider\Model\ResourceModel\Homeslider\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * $_filter variable
     *
     * @var [type]
     */
    protected $_filter;

    /**
     * $_collectionFactory variable
     *
     * @var [type]
     */
    protected $_collectionFactory;

    /**
     * Comment of __construct function
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {

        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Comment of execute function
     *
     * @return void
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $recordDeleted = 0;
        foreach ($collection->getItems() as $record) {
            $record->setId($record->getId());
            $record->delete();
            $recordDeleted++;
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $recordDeleted));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    /**
     * Comment of _isAllowed function
     *
     * @return void
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elsnertech_Homeslider::row_data_delete');
    }
}
