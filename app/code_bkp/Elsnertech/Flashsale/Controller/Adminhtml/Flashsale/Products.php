<?php
namespace Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;

use Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Layout;
use Magento\Framework\Exception;

class Products extends Flashsale
{

    /**
     * Dispatch request
     *
     * @return Layout
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $filter = $this->getRequest()->getParam('filter');
        $params=$this->getRequest()->getParams();
        if ($id) {
            try {
                $flashsale = $this->flashsaleRepository->getById($id);
            } catch (Exception $e) {
                $this->messageManager->addError(__('This flashsale no longer exists.'));
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
        $this->coreRegistry->register('flashsale_flashsale_products', $flashsale);
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        return $resultLayout;
    }
}
