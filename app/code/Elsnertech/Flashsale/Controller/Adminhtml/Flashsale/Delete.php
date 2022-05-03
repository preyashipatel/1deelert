<?php

namespace Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;

use Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Controller\Result\Redirect;
use Exception;

class Delete extends Flashsale
{
    /**
     * Dispatch request
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $this->messageManager->addError(__('There is no id delivered.'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $this->flashsaleRepository->deleteById($id);
            $this->messageManager->addSuccess(__('You deleted the Flash sale.'));
            return $resultRedirect->setPath('*/*/');
        } catch (Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
    }
}
