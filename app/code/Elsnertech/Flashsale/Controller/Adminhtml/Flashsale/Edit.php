<?php

namespace Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;

use Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Exception;

class Edit extends Flashsale
{
    /**
     * Dispatch request
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            try {
                $flashsale = $this->flashsaleRepository->getById($id);
            } catch (Exception $e) {
                $this->messageManager->addError(__('This Flashsale no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $flashsale = $this->flashsaleFactory->create();
        }

        $data = $this->_session->getFormData(true);

        if (!empty($data)) {
            $flashsale->setData($data);
        }

        $this->coreRegistry->register('flashsale', $flashsale);

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Flashsale') : __('New Flashsale'),
            $id ? __('Edit Flashsale') : __('New Flashsale')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Flashsales'));
        $resultPage->getConfig()->getTitle()->prepend($flashsale->getId() ? $flashsale->getName() : __('New Flashsale'));

        return $resultPage;
    }
}
