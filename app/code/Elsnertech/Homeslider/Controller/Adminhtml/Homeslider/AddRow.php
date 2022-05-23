<?php

namespace Elsnertech\Homeslider\Controller\Adminhtml\Homeslider;

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{

    /**
     * $coreRegistry variable
     *
     * @var [type]
     */
    private $coreRegistry;

    /**
     * $HomesliderFactory variable
     *
     * @var [type]
     */
    private $HomesliderFactory;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Elsnertech\Homeslider\Model\HomesliderFactory $HomesliderFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Elsnertech\Homeslider\Model\HomesliderFactory $HomesliderFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->HomesliderFactory = $HomesliderFactory;
    }

    /**
     * Comment of execute function
     *
     * @return void
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->HomesliderFactory->create();
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = $rowData->getTitle();
            if (!$rowData->getId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('homeslider/homeslider/rowdata');
                return;
            }
        }

        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Images ').$rowTitle : __('Add Banner');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }

    /**
     * Comment of _isAllowed function
     *
     * @return void
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elsnertech_Homeslider::add_row');
    }
}
